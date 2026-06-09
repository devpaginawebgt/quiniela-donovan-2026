<?php

namespace App\Http\Controllers;

use App\Http\Requests\PushNotification\StorePushNotificationRequest;
use App\Http\Requests\PushNotification\UpdatePushNotificationRequest;
use App\Http\Services\PushNotificationService;
use App\Models\Country;
use App\Models\PushNotification;
use App\Models\PushNotificationType;
use App\Models\UserType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PushNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('modulos.admin.notifications');
    }

    /**
     * Server-side data for the notifications DataTable.
     */
    public function data()
    {
        $query = PushNotification::query()
            ->where('push_notification_type_id', 1)
            ->where('status', '!=', 'canceled')
            ->with(['userType:id,plural_name', 'country:id,name'])
            ->orderByRaw("FIELD(status, 'pending') DESC")
            ->orderBy('scheduled_at', 'asc');

        return DataTables::eloquent($query)
            ->addColumn('fecha', fn($n) => $n->created_at?->timezone('America/Guatemala')->format('d/m/Y h:i A') ?? '—')
            ->addColumn('audiencia', function ($n) {
                if (! $n->user_type_id && ! $n->country_id) {
                    return 'Todos los participantes';
                }

                return collect([
                    $n->userType?->plural_name,
                    $n->country?->name,
                ])->filter()->implode(' · ');
            })
            ->addColumn('scheduled_at_formatted', fn($n) => $n->scheduled_at?->timezone('America/Guatemala')->format('d/m/Y h:i A') ?? '—')
            ->addColumn('status_badge', function ($n) {
                return $this->statusBadgeHtml($n->status);
            })
            ->addColumn('acciones', function ($n) {
                $canEditOrCancel = $n->status === PushNotification::STATUS_PENDING;
                $disabledAttrs = $canEditOrCancel ? '' : 'disabled aria-disabled="true"';

                $editUrl = route('web.admin.notifications.edit', $n);
                $editEnabledClasses = 'bg-secondary text-primary hover:brightness-110';
                $editDisabledClasses = 'bg-gray-200 text-gray-400 cursor-not-allowed pointer-events-none';
                $editButton = $canEditOrCancel
                    ? '<a href="' . $editUrl . '"
                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg transition-colors ' . $editEnabledClasses . '"
                            title="Editar">
                            <span class="icon-[material-symbols--edit-outline-rounded] w-5 h-5"></span>
                        </a>'
                    : '<span class="inline-flex items-center justify-center w-8 h-8 rounded-lg ' . $editDisabledClasses . '"
                            title="Solo se pueden editar notificaciones pendientes">
                            <span class="icon-[material-symbols--edit-outline-rounded] w-5 h-5"></span>
                        </span>';

                $cancelClasses = $canEditOrCancel
                    ? 'bg-red-600 text-light hover:brightness-110'
                    : 'bg-gray-200 text-gray-400 cursor-not-allowed';

                return '
                    <div class="flex items-center justify-center gap-1">
                        <button type="button"
                            class="js-notification-show inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary text-light hover:brightness-110 transition-colors"
                            data-id="' . $n->id . '"
                            title="Ver detalle">
                            <span class="icon-[material-symbols--visibility-outline-rounded] w-5 h-5"></span>
                        </button>
                        ' . $editButton . '
                        <button type="button"
                            class="js-notification-cancel inline-flex items-center justify-center w-8 h-8 rounded-lg transition-colors ' . $cancelClasses . '"
                            data-id="' . $n->id . '"
                            ' . $disabledAttrs . '
                            title="' . ($canEditOrCancel ? 'Cancelar envío' : 'Solo se pueden cancelar notificaciones pendientes') . '">
                            <span class="icon-[material-symbols--cancel] w-5 h-5"></span>
                        </button>
                    </div>
                ';
            })
            ->filterColumn('fecha', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(created_at, '%d/%m/%Y') LIKE ?", ["%{$keyword}%"]);
            })
            ->filterColumn('scheduled_at_formatted', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(scheduled_at, '%d/%m/%Y') LIKE ?", ["%{$keyword}%"]);
            })
            ->filterColumn('audiencia', function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->whereHas('userType', fn($q) => $q->where('plural_name', 'like', "%{$keyword}%"))
                      ->orWhereHas('country', fn($q) => $q->where('name', 'like', "%{$keyword}%"));
                });
            })
            ->rawColumns(['status_badge', 'acciones'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        $userTypes = UserType::orderBy('name')->get(['id', 'name', 'plural_name']);

        return view('modulos.admin.notification-form', compact('countries', 'userTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePushNotificationRequest $request, PushNotificationService $service)
    {
        $data = $request->validated();

        $scheduleEnabled = (string) ($data['schedule_enabled'] ?? '0') === '1';

        $userTimezone = $request->user()->country?->timezone ?? config('app.timezone');

        $scheduledAtLocal = $scheduleEnabled
            ? Carbon::createFromFormat('Y-m-d H:i', $data['send_at_date'] . ' ' . $data['send_at_time'], $userTimezone)
            : null;

        $scheduledAtUtc = $scheduledAtLocal?->copy()->utc();

        // Para envío inmediato validamos destinatarios antes de crear el registro.
        // Para envío programado se omite: la audiencia puede cambiar antes de disparar.
        $recipients = null;

        if (! $scheduleEnabled) {
            $recipients = $service->filterRecipients($data);

            if ($recipients->isEmpty()) {
                return redirect()
                    ->route('web.admin.notifications.create')
                    ->with('warning', 'No hay usuarios con notificaciones activadas que coincidan con los filtros seleccionados.');
            }
        }

        // Save image in public storage before saving the notification

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('push-notifications', 'public');
        }

        // Create push notification in db

        $adminType = PushNotificationType::where('slug', PushNotificationType::ADMIN)->first();

        $pushNotification = PushNotification::create([
            'push_notification_type_id' => $adminType?->id,
            'title'        => $data['title'],
            'description'  => $data['description'],
            'image_path'   => $imagePath,
            'user_type_id' => $data['user_type_id'] ?? null,
            'country_id'   => $data['country_id'] ?? null,
            'status'       => $scheduleEnabled ? PushNotification::STATUS_PENDING : PushNotification::STATUS_SENDING,
            'scheduled_at' => $scheduleEnabled ? $scheduledAtUtc : now(),
            'created_by'   => $request->user()->id,
            'from_system'  => false,
        ]);

        if ($scheduleEnabled) {
            return redirect()
                ->route('web.admin.notifications.create')
                ->with('status', 'Notificación programada para el ' . $scheduledAtLocal->format('d/m/Y H:i') . '.');
        }

        // Validate notifications sent

        $result = $service->sendAdminNotification($pushNotification, $recipients);

        $pushNotification->update([
            'status'     => $result['success'] ? PushNotification::STATUS_SENT : PushNotification::STATUS_FAILED,
            'sent_at'    => now(),
            'recipients' => $result['total'],
            'success'    => $result['success'],
            'failed'     => $result['failed'],
            'comment'    => $result['error'],
        ]);

        if ($result['success'] === false) {
            return redirect()
                ->route('web.admin.notifications.create')
                ->with('error', 'Ocurrió un error al enviar las notificaciones, intenta nuevamente o contacta a Soporte.');
        }

        return redirect()
            ->route('web.admin.notifications.create')
            ->with('status', '¡Notificación enviada correctamente!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PushNotification $notification)
    {
        $notification->load(['userType:id,plural_name', 'country:id,name', 'creator:id,nombres,apellidos']);

        $tz = 'America/Guatemala';

        $audience = (! $notification->user_type_id && ! $notification->country_id)
            ? 'Todos los participantes'
            : collect([
                $notification->userType?->plural_name,
                $notification->country?->name,
            ])->filter()->implode(' · ');

        return response()->json([
            'id'           => $notification->id,
            'title'        => $notification->title,
            'description'  => $notification->description,
            'image_url'    => $notification->image_path ? asset('storage/' . $notification->image_path) : null,
            'audience'     => $audience,
            'status'       => $notification->status,
            'status_label' => $this->statusLabel($notification->status),
            'scheduled_at' => $notification->scheduled_at?->timezone($tz)->format('d/m/Y h:i A'),
            'sent_at'      => $notification->sent_at?->timezone($tz)->format('d/m/Y h:i A'),
            'recipients'   => $notification->recipients,
            'success'      => $notification->success,
            'failed'       => $notification->failed,
            'comment'      => $notification->comment,
            'created_by'   => trim(($notification->creator?->nombres ?? '') . ' ' . ($notification->creator?->apellidos ?? '')) ?: null,
            'created_at'   => $notification->created_at?->timezone($tz)->format('d/m/Y h:i A'),
        ]);
    }

    /**
     * Cancel a pending notification (state transition only — no physical delete).
     */
    public function cancel(Request $request, PushNotification $notification)
    {
        if ($notification->status !== PushNotification::STATUS_PENDING) {
            return response()->json([
                'ok'      => false,
                'message' => 'Solo se pueden cancelar notificaciones pendientes de envío.',
            ], 422);
        }

        $user = $request->user();
        $stamp = now()->timezone('America/Guatemala')->format('d/m/Y H:i');
        $byName = trim(($user?->nombres ?? '') . ' ' . ($user?->apellidos ?? '')) ?: ('usuario #' . $user?->id);

        $notification->update([
            'status'  => PushNotification::STATUS_CANCELED,
            'comment' => "Cancelada manualmente por {$byName} el {$stamp}.",
        ]);

        return response()->json([
            'ok'     => true,
            'status' => PushNotification::STATUS_CANCELED,
        ]);
    }

    /**
     * Show the form for editing a pending notification.
     */
    public function edit(PushNotification $notification)
    {
        if ($notification->status !== PushNotification::STATUS_PENDING) {
            return redirect()
                ->route('web.admin.notifications.index')
                ->with('warning', 'Solo se pueden editar notificaciones pendientes de envío.');
        }

        $countries = Country::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        $userTypes = UserType::orderBy('name')->get(['id', 'name', 'plural_name']);

        return view('modulos.admin.notification-edit', compact('notification', 'countries', 'userTypes'));
    }

    /**
     * Update a pending notification. If the user disables the schedule toggle,
     * the notification is sent immediately as part of the update.
     */
    public function update(UpdatePushNotificationRequest $request, PushNotification $notification, PushNotificationService $service)
    {
        $data = $request->validated();

        $scheduleEnabled = (string) ($data['schedule_enabled'] ?? '0') === '1';
        $removeImage = (string) ($data['remove_image'] ?? '0') === '1';

        $userTimezone = $request->user()->country?->timezone ?? config('app.timezone');

        $scheduledAtLocal = $scheduleEnabled
            ? Carbon::createFromFormat('Y-m-d H:i', $data['send_at_date'] . ' ' . $data['send_at_time'], $userTimezone)
            : null;

        $scheduledAtUtc = $scheduledAtLocal?->copy()->utc();

        // Envío inmediato: validar destinatarios antes de tocar el registro.
        $recipients = null;

        if (! $scheduleEnabled) {
            $recipients = $service->filterRecipients($data);

            if ($recipients->isEmpty()) {
                return redirect()
                    ->route('web.admin.notifications.edit', $notification)
                    ->withInput()
                    ->with('warning', 'No hay usuarios con notificaciones activadas que coincidan con los filtros seleccionados.');
            }
        }

        // Imagen: nueva > eliminar actual > mantener.
        $imagePath = $notification->image_path;

        if ($request->hasFile('image')) {
            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('push-notifications', 'public');
        } elseif ($removeImage && $imagePath) {
            Storage::disk('public')->delete($imagePath);
            $imagePath = null;
        }

        $notification->update([
            'title'        => $data['title'],
            'description'  => $data['description'],
            'image_path'   => $imagePath,
            'user_type_id' => $data['user_type_id'] ?? null,
            'country_id'   => $data['country_id'] ?? null,
            'status'       => $scheduleEnabled ? PushNotification::STATUS_PENDING : PushNotification::STATUS_SENDING,
            'scheduled_at' => $scheduleEnabled ? $scheduledAtUtc : now(),
        ]);

        if ($scheduleEnabled) {
            return redirect()
                ->route('web.admin.notifications.index')
                ->with('status', 'Notificación actualizada. Reprogramada para el ' . $scheduledAtLocal->format('d/m/Y H:i') . '.');
        }

        $result = $service->sendAdminNotification($notification, $recipients);

        $notification->update([
            'status'     => $result['success'] ? PushNotification::STATUS_SENT : PushNotification::STATUS_FAILED,
            'sent_at'    => now(),
            'recipients' => $result['total'],
            'success'    => $result['success'],
            'failed'     => $result['failed'],
            'comment'    => $result['error'],
        ]);

        if ($result['success'] === false) {
            return redirect()
                ->route('web.admin.notifications.index')
                ->with('error', 'Ocurrió un error al enviar las notificaciones, intenta nuevamente o contacta a Soporte.');
        }

        return redirect()
            ->route('web.admin.notifications.index')
            ->with('status', '¡Notificación actualizada y enviada correctamente!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PushNotification $pushNotification)
    {
        //
    }

    private function statusLabel(string $status): string
    {
        return match ($status) {
            PushNotification::STATUS_PENDING  => 'Pendiente',
            PushNotification::STATUS_SENDING  => 'Enviando',
            PushNotification::STATUS_SENT     => 'Enviada',
            PushNotification::STATUS_FAILED   => 'Fallida',
            PushNotification::STATUS_CANCELED => 'Cancelada',
            default                           => ucfirst($status),
        };
    }

    private function statusBadgeHtml(string $status): string
    {
        [$bg, $text, $border, $dot, $label] = match ($status) {
            PushNotification::STATUS_SENT     => ['bg-green-100',  'text-green-700',  'border-green-200',  'bg-green-600',  'Enviada'],
            PushNotification::STATUS_SENDING  => ['bg-blue-100',   'text-blue-700',   'border-blue-200',   'bg-blue-600',   'Enviando'],
            PushNotification::STATUS_PENDING  => ['bg-amber-100',  'text-amber-700',  'border-amber-200',  'bg-amber-500',  'Pendiente'],
            PushNotification::STATUS_FAILED   => ['bg-red-100',    'text-red-700',    'border-red-200',    'bg-red-600',    'Fallida'],
            PushNotification::STATUS_CANCELED => ['bg-gray-100',   'text-gray-700',   'border-gray-200',   'bg-gray-500',   'Cancelada'],
            default                           => ['bg-gray-100',   'text-gray-700',   'border-gray-200',   'bg-gray-500',   ucfirst($status)],
        };

        return '
            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 text-xs font-medium rounded-full border ' . $bg . ' ' . $text . ' ' . $border . '">
                <span class="w-1.5 h-1.5 rounded-full ' . $dot . '"></span>
                ' . $label . '
            </span>
        ';
    }
}
