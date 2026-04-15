<?php

namespace App\Http\Services;

use App\Models\Bonus;
use App\Models\User;

class UserBonusService {

    public function addUserBonus(string|int $bonus_id)
    {
        $user = request()->user();
        $bonus = Bonus::find($bonus_id);

        if (empty($bonus)) {
            return;
        }

        $user->bonuses()->create([
            'bonus_id' => $bonus->id,
            'puntos' => $bonus->puntos,
        ]);

        $this->updateUserBonusPoints($user);
    }

    public function addUserBonusWithUser(User $user, string|int $bonus_id)
    {
        $bonus = Bonus::find($bonus_id);

        $user->bonuses()->create([
            'bonus_id' => $bonus->id,
            'puntos' => $bonus->puntos,
        ]);

        $this->updateUserBonusPoints($user);
    }

    public function updateUserBonusPoints(User $user)
    {
        $puntos_bonus = $user->bonuses()->sum('puntos');

        $user->puntos_bonus = $puntos_bonus;
        $user->puntos = $user->puntos_bonus + $user->puntos_trivias + $user->puntos_predicciones;

        $user->save();
    }

    public function updateUserBonusPointsChunked()
    {
        User::where('status_user', 1)
            ->with('bonuses')
            ->has('bonuses')
            ->chunkById(500, function ($users) {
                foreach ($users as $user) {
                    $puntos_bonus = $user->bonuses()->sum('puntos');

                    $user->puntos_bonus = $puntos_bonus;
                    $user->puntos = $user->puntos_bonus + $user->puntos_trivias + $user->puntos_predicciones;

                    $user->save();
                }
            });
    }

}
