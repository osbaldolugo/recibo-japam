@component('mail::message')

<b>Buen día !</b>

Has solicitado reestablecer la contraseña de tu cuenta JAPAM .

@component('mail::button', ['url' => route('appUser.password.reset',$token)])
Reestablecer Contraseña
@endcomponent


Si no has solicitado reestablecer tu contraseña, puedes ignorar este correo, gracias.


Saludos.


@endcomponent