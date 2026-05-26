<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PushNotification extends Model
{
    public const STATUS_PENDING  = 'pending';
    public const STATUS_SENDING  = 'sending';
    public const STATUS_SENT     = 'sent';
    public const STATUS_FAILED   = 'failed';
    public const STATUS_CANCELED = 'canceled';

    protected $fillable = [
        'push_notification_type_id',
        'partido_id',
        'title',
        'description',
        'image_path',
        'user_type_id',
        'country_id',
        'status',
        'scheduled_at',
        'sent_at',
        'recipients',
        'success',
        'failed',
        'comment',
        'created_by',
        'from_system',
    ];

    protected function casts(): array
    {
        return [
            'push_notification_type_id' => 'integer',
            'partido_id'   => 'integer',
            'user_type_id' => 'integer',
            'country_id'   => 'integer',
            'scheduled_at' => 'datetime',
            'sent_at'      => 'datetime',
            'recipients'   => 'integer',
            'success'      => 'boolean',
            'failed'       => 'integer',
            'created_by'   => 'integer',
            'from_system'  => 'boolean',
        ];
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(PushNotificationType::class, 'push_notification_type_id');
    }

    public function partido(): BelongsTo
    {
        return $this->belongsTo(Partido::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function userType(): BelongsTo
    {
        return $this->belongsTo(UserType::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
