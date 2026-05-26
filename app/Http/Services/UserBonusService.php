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
        $all_bonuses = $user->bonuses()
            ->where('is_active', true)
            ->with('bonus')
            ->get();

        $user->puntos_bonus_grupos = $all_bonuses->where('bonus.ranking_tab_id', 1)->sum('puntos');
        $user->puntos_bonus        = $all_bonuses->where('bonus.ranking_tab_id', 2)->sum('puntos');

        $user->puntos_grupos = $user->puntos_bonus_grupos + $user->puntos_trivias_grupos + $user->puntos_predicciones_grupos;
        $user->puntos        = $user->puntos_bonus + $user->puntos_trivias + $user->puntos_predicciones;

        $user->save();
    }

    public function updateUserBonusPointsChunked()
    {
        User::where('status_user', 1)
            ->has('bonuses')
            ->chunkById(1000, function ($users) {
                foreach ($users as $user) {
                    $this->updateUserBonusPoints($user);
                }
            });
    }

}
