<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'username', 'is_admin',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Связь: один пользователь может владеть несколькими персонажами (один ко многим)
    public function characters() {
        return $this->hasMany(Character::class);
    }

    // Расширенный уровень: используем уникальный никнейм для формирования ссылок в браузере (вместо числового ID)
    public function getRouteKeyName() {
        return 'username';
    }

    // Автоматизация: перед созданием нового пользователя генерируем ему никнейм на основе имени
    protected static function booted()
    {
        static::creating(function ($user) {
            if (!$user->username) {
                // Создаем безопасную строку для URL и добавляем случайное число для уникальности
                $user->username = Str::slug($user->name) . '_' . rand(100, 999);
            }
        });
    }
}