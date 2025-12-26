<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Character;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [];

    /**
     * Регистрация правил доступа (Gates) для многопользовательской системы
     */
    public function boot() {
        $this->registerPolicies();

        // Правило для редактирования и удаления: 
        // Доступ разрешен только автору персонажа или админу
        Gate::define('update-character', function (User $user, Character $character) {
            return $user->id === $character->user_id || $user->is_admin;
        });

        Gate::define('admin-only', function (User $user) {
            return $user->is_admin;
        });
    }
}