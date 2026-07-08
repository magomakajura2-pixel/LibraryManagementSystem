<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetting extends Model
{
    use HasFactory;

    protected $primaryKey = 'setting_key';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'setting_key', 'setting_value', 'description',
    ];

    public static function value(string $key, mixed $default = null): mixed
    {
        return static::find($key)?->setting_value ?? $default;
    }
}
