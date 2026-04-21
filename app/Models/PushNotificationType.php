<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PushNotificationType extends Model
{
    public const SYSTEM = 'system';
    public const MATCH = 'match';

    protected $fillable = [
        'name',
        'slug',
    ];

    public function pushNotifications(): HasMany
    {
        return $this->hasMany(PushNotification::class);
    }
}
