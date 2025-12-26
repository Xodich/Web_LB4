<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'is_admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function characters() {
        return $this->hasMany(Character::class);
    }

    // Требование расширенного уровня: URL через username, а не ID
    public function getRouteKeyName() {
        return 'username';
    }


    protected static function booted()
    {
        static::creating(function ($user) {
            // Если username не был введен вручную
            if (!$user->username) {
                // Берем имя пользователя, превращаем в транслит (slug) 
                // и добавляем рандомное число для уникальности
                $user->username = \Illuminate\Support\Str::slug($user->name) . '_' . rand(100, 999);
            }
        });
    }

}
