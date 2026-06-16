<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'apellidos',
        'rut',
        'telefono',
        'direccion',
        'rol',
        'email',
        'password',
        'permisos',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'permisos' => 'array',
        ];
    }

    /**
     * Lista completa de permisos disponibles en el sistema.
     */
    public static function permisosDisponibles(): array
    {
        return [
            'clientes', 'productos', 'entradas',
            'cotizaciones', 'facturas',
            'informe_facturacion', 'usuarios',
        ];
    }

    /**
     * Verifica si el usuario tiene un permiso específico.
     * El administrador siempre tiene todos los permisos.
     */
    public function tienePermiso(string $permiso): bool
    {
        if ($this->rol === 'administrador') {
            return true;
        }
        return in_array($permiso, $this->permisos ?? []);
    }
}