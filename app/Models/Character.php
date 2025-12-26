<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Character extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'character_name', 
        'character_tag', 
        'short_description', 
        'full_biography', 
        'image_path', 
        'release_date',
        'user_id'
    ];

    // Готовит дату к записи в базу (превращает её в формат SQL)
    public function setReleaseDateAttribute($value)
    {
        $this->attributes['release_date'] = $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    // Аксессор: вывод на экран
    public function getReleaseDateAttribute($value)
    {
        return $value ? \Carbon\Carbon::parse($value)->format('d.m.Y') : null;
    }



    public function user() {
        return $this->belongsTo(User::class);
    }

    // Требование: Проверка прав через Events/Closures на уровне модели
    protected static function booted() {
        static::deleting(function ($character) {
            if (auth()->check() && !auth()->user()->is_admin && auth()->id() !== $character->user_id) {
                abort(403, 'У вас нет прав на удаление этого объекта');
            }
        });
    }
}