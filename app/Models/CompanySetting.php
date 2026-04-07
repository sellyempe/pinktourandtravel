<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanySetting extends Model
{
    use HasFactory;

    protected $table = 'company_settings';

    protected $fillable = [
        'key',
        'value',
        'type',
        'label',
        'description',
        'category',
    ];

    protected $casts = [
        'value' => 'string',
    ];

    // Scopes
    public function scopeByKey($query, $key)
    {
        return $query->where('key', $key);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // Accessors
    public static function get($key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    public static function set($key, $value, $type = 'string', $label = null, $description = null, $category = 'general')
    {
        return self::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'label' => $label,
                'description' => $description,
                'category' => $category,
            ]
        );
    }
}
