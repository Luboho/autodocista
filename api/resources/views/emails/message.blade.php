@component('mail::message')
<b>Kontaktné údaje zákazníka: </b>
<br>
<b>Meno:</b> {{ $data['name']  }} 
<br>
<b>Email:</b> {{ $data['email']  }} 
<br>
<b>Telefón:</b> {{ $data['phone']  }} 
<br>


<b>Správa:</b>
<br> 
{{ $data['message'] }}



@endcomponent