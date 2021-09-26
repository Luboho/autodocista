@component('mail::message')
{{ $data['name']  }}

Prosím, overte svoj e-mail

@component('mail::button', ["url" => "http://localhost:3000/auth/forgot-password/verify/" . $data['email_verification_code'] . '-' . $data['id']])
Overiť E-mail
@endcomponent

<br />
<small>Ak odkaz vyššie nefunguje, prosím kliknite na tento odkaz: <a href="{{ "http://localhost:3000/auth/verify/" . $data['email_verification_code'] . '-' . $data['id'] }}">Overiť email</a></small>
<br />
Ďakujeme<br>
{{ config('app.name') }}
@endcomponent