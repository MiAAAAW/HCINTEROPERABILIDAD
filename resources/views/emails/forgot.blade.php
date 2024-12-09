@component('mail::message')
Hello {{$user->name}},

<p>Entendemos estos casos.</p>

@component('mail::button',['url' => url('reset/' .$user->remember_token)])
Reinicie su Contraseña
@endcomponent 

<p>Si tiene problemas , COntacteSE con el Admninistrador del Residentado Medico Unap</p>

Gracias,<br>


{{config ('app.name')}}
    
@endcomponent