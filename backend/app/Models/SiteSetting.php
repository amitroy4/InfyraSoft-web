<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Throwable;

class SiteSetting extends Model
{
    protected $fillable = [
        'setting_key',
        'setting_value',
    ];

    public static function toKeyValueMap(): Collection
    {
        try {
            return self::query()
                ->pluck('setting_value', 'setting_key');
        } catch (Throwable $throwable) {
            return collect();
        }
    }
}
