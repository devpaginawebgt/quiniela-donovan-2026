<?php

namespace App\Console\Commands;

use App\Http\Services\UserBonusService;
use App\Models\Bonus;
use App\Models\User;
use Illuminate\Console\Command;

class AddTestBonus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-test-bonus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test para agregar bonus a un usuario que cumpla una regla';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $bonus = Bonus::where('code', 'test-bonus')->first();

        if (!empty($bonus)) {
            $this->error('Este bonus ya existe en la base de datos.');
            return Command::FAILURE;
        }

        $bonus = Bonus::create([
            'name' => 'Test bonus',
            'code' => 'test-bonus',
            'description' => 'Bonus creado para testear puntos adicionales',
            'puntos' => 1,
        ]);

        if (empty($bonus)) {
            $this->error('Error al crear el bonus.');
            return Command::FAILURE;
        }

        $users = User::where('email', 'LIKE', '%paginawebguatemala.com')->get();

        if (empty($users)) {
            $this->error('No se encontraron usuarios que cumplen esta condición.');
            return Command::FAILURE;
        }

        foreach($users as $user) {
            try {
                $service = new UserBonusService();
                $service->addUserBonusWithUser($user, $bonus->id);

                $this->info("Puntos actualizados correctamente, {$user->id}.");
            } catch (\Exception $e) {
                $this->error('Error al actualizar puntos: ' . $e->getMessage());

                return Command::FAILURE;
            }
        }

    }
}
