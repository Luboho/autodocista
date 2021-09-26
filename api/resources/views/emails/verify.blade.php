@component('mail::message')
Ahoj, {{ $data['name']  }}

Prosím potvrďte svoj email kliknutím na odkaz.

@component('mail::button', ["url" => "http://localhost:3000/auth/verify/" . $data['email_verification_code'] . '-' . $data['id']])
Overiť email
@endcomponent

<br />
<small>Ak odkaz vyššie nefunguje, prosím kliknite na tento odkaz: <a href="{{ "http://localhost:3000/auth/verify/" . $data['email_verification_code'] . '-' . $data['id'] }}">Overiť email</a></small>
<br />
Ďakujeme,<br>
{{ config('app.name') }}
@endcomponent