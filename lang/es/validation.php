<?php

return [
    'unique'   => 'Este :attribute ya está registrado.',
    'required' => 'El campo :attribute es obligatorio.',
    'numeric'  => 'El campo :attribute debe ser un número.',
    'integer'  => 'El campo :attribute debe ser un número entero.',
    'min'      => [
        'numeric' => 'El campo :attribute debe ser al menos :min.',
        'string'  => 'El campo :attribute debe tener al menos :min caracteres.',
    ],
    'max'      => [
        'numeric' => 'El campo :attribute no debe ser mayor que :max.',
        'string'  => 'El campo :attribute no debe tener más de :max caracteres.',
    ],
    'string'   => 'El campo :attribute debe ser texto.',
    'email'    => 'El campo :attribute debe ser un correo válido.',
    'confirmed'=> 'La confirmación de :attribute no coincide.',

    'attributes' => [
        'nombre'              => 'nombre',
        'codigo'              => 'código',
        'costo'               => 'costo',
        'porcentaje_ganancia' => 'porcentaje de ganancia',
        'stock'               => 'stock',
        'categoria'           => 'categoría',
        'descripcion'         => 'descripción',
        'name'                => 'nombre',
        'email'               => 'correo electrónico',
        'password'            => 'contraseña',
        'apellidos'           => 'apellidos',
        'telefono'            => 'teléfono',
        'direccion'           => 'dirección',
        'rol'                 => 'tipo de usuario',
        'cedula'              => 'cédula',
        'celular'             => 'celular',
    ],
];