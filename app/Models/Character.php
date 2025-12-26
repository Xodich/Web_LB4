<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Character extends Model
{
    // персонажи не удаляются навсегда, а помечаются как "удаленные"
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

    // Мутатор
    public function setReleaseDateAttribute($value)
    {
        $this->attributes['release_date'] = $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    // Аксессор
    public function getReleaseDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('d.m.Y') : null;
    }

    // Обратная связь: каждый персонаж закреплен за конкретным пользователем
    public function user() {
        return $this->belongsTo(User::class);
    }

    // Проверка прав на уровне модели: запрещаем удаление чужих объектов всем, кроме администратора
    protected static function booted() {
        static::deleting(function ($character) {
            // Если текущий пользователь не админ и не автор этого героя — прерываем операцию
            if (auth()->check() && !auth()->user()->is_admin && auth()->id() !== $character->user_id) {
                abort(403, 'У вас нет прав на удаление этого объекта');
            }
        });
    }
}