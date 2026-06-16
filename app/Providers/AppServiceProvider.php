<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Forzar HTTPS en producción (necesario detrás del proxy de Render)
        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        // Gates por rol (los que ya tenías)
        Gate::define('admin', fn($user) => $user->rol === 'administrador');
        Gate::define('vendedor', fn($user) =>
            $user->rol === 'vendedor' || $user->rol === 'administrador'
        );

        // Un Gate por cada permiso del sistema
        foreach (User::permisosDisponibles() as $permiso) {
            Gate::define($permiso, fn($user) => $user->tienePermiso($permiso));
        }
    }
}