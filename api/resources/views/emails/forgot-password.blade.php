@component('mail::message')
Hi, {{ $data['name']  }}

Prosím, overte svoj e-mail

@component('mail::button', ["url" => "http://localhost:3000/auth/forgot-password/verify/" . $data['email_verification_code'] . '-' . $data['id']])
Overiť E-mail
@endcomponent

{{-- If the button not work, please click on this url: {{ "http://localhost:3000/auth/verify/" . $data['email_verification_code'] . '-' . $data['id']] }} --}}

Thanks,<br>
{{ config('app.name') }}
@endcomponent