<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SystemSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'description',
    ];

    public static function get(string $key, mixed $default = null): mixed
    {
        $row = Cache::remember(
            "system_setting:{$key}",
            now()->addMinutes(10),
            fn () => static::where('key', $key)->first()
        );

        return $row?->value ?? $default;
    }

    public static function getInt(string $key, int $default = 0): int
    {
        return (int) static::get($key, $default);
    }

    protected static function booted(): void
    {
        static::saved(fn (SystemSetting $setting) => Cache::forget("system_setting:{$setting->key}"));
        static::deleted(fn (SystemSetting $setting) => Cache::forget("system_setting:{$setting->key}"));
    }
}
