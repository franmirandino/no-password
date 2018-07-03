@component('mail::message')
# Link de acceso para {{ $user->name }}

Da click en el sgte boton para acceder automáticamente a la aplicación

@component('mail::button', ['url' => $link])
Acceder
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
