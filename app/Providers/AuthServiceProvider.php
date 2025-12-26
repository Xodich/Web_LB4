<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Character;
use App\Models\User;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() {
        $this->registerPolicies();

        // Может ли пользователь редактировать/удалять объект?
        Gate::define('update-character', function (User $user, Character $character) {
            return $user->id === $character->user_id || $user->is_admin;
        });

        // Действия только для админа
        Gate::define('admin-only', function (User $user) {
            return $user->is_admin;
        });
    }
}
