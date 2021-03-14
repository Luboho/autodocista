@component('mail::message')
<b>Kontaktné údaje zákazníka: </b>
<br>
<b>Email:</b> {{ $data['email']  }} 
<br>
<b>Telefon:</b> {{ $data['phone']  }} 
<br>


<b>Správa:</b>
<br> 
{{ $data['message'] }}



<b>Meno:</b> {{ $data['name']  }} 
@endcomponent