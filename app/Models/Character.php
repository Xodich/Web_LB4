<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Character extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'character_name', 'character_tag', 'short_description', 
        'full_biography', 'image_path', 'release_date'
    ];

    // Готовит дату к записи в базу (превращает её в формат SQL)
    public function setReleaseDateAttribute($value)
    {
        $this->attributes['release_date'] = $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    // Аксессор: вывод на экран
    public function getReleaseDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d.m.Y') : null;
    }
}