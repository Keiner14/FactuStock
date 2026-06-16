<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index()
{
    $usuarios = User::orderBy('id', 'asc')->get();
    return view('usuarios.index', compact('usuarios'));
}

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'apellidos'  => 'required|string|max:255',
            'telefono'   => 'required|string|max:20',
            'direccion'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:8|confirmed',
            'rol'        => 'required|in:administrador,vendedor',
            'permisos'   => 'nullable|array',
            'permisos.*' => 'string|in:' . implode(',', User::permisosDisponibles()),
        ]);

        $permisos = $request->rol === 'administrador'
            ? User::permisosDisponibles()
            : ($request->permisos ?? []);

        // Corrige la secuencia del ID en PostgreSQL
        $maxId = User::max('id') ?? 0;
        DB::statement("SELECT setval('users_id_seq', $maxId)");

        User::create([
            'name'      => $request->name,
            'apellidos' => $request->apellidos,
            'telefono'  => $request->telefono,
            'direccion' => $request->direccion,
            'email'     => $request->email,
            'password'  => Hash::make($request->password),
            'rol'       => $request->rol,
            'permisos'  => $permisos,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $usuario)
    {
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, User $usuario)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'apellidos'  => 'required|string|max:255',
            'telefono'   => 'required|string|max:20',
            'direccion'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email,' . $usuario->id,
            'rol'        => 'required|in:administrador,vendedor',
            'permisos'   => 'nullable|array',
            'permisos.*' => 'string|in:' . implode(',', User::permisosDisponibles()),
        ]);

        $permisos = $request->rol === 'administrador'
            ? User::permisosDisponibles()
            : ($request->permisos ?? []);

        $usuario->update([
            'name'      => $request->name,
            'apellidos' => $request->apellidos,
            'telefono'  => $request->telefono,
            'direccion' => $request->direccion,
            'email'     => $request->email,
            'rol'       => $request->rol,
            'permisos'  => $permisos,
        ]);

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $usuario->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy(User $usuario)
    {
        $usuario->delete();
        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado correctamente.');
    }
}