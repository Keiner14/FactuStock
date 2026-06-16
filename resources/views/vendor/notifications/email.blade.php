@component('mail::message')
# ¡Hola!

Recibiste este correo porque se solicitó restablecer la contraseña de tu cuenta.

@component('mail::button', ['url' => $actionUrl, 'color' => 'primary'])
Restablecer Contraseña
@endcomponent

Este enlace expirará en 60 minutos.

Si no solicitaste restablecer tu contraseña, no es necesario que hagas nada.

Saludos,
{{ config('app.name') }}
@endcomponent