<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PushNotification extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image_path',
        'user_type_id',
        'country_id',
        'users_count',
        'created_by',
        'from_system',
    ];

    protected function casts(): array
    {
        return [
            'user_type_id' => 'integer',
            'country_id'   => 'integer',
            'users_count'  => 'integer',
            'created_by'   => 'integer',
            'from_system'  => 'boolean',
        ];
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
