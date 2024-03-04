@component('mail::message', ['title' => $title])
Salam Sejahtera Tuan/Puan {{$nama}},<br><br>
Adakah anda mahu menetapkan semula kata laluan anda?<br><br>
Seseorang telah meminta untuk menetapkan semula kata laluan untuk akaun <b>{{$emel}}</b>. Sila klik butang di bawah untuk menetapkan semula kata laluan. Sekiranya anda tidak meminta penetapan semula kata laluan ini, anda boleh mengabaikan e-mel ini.<br>
@component('mail::button', ['url' => $reset_url])
    Tukar Kata Laluan
@endcomponent
<p class="sub" style="text-align: center">atau tekan pautan ini: {{$reset_url}}</p>

Sekian,<br>
Terima kasih,<br>
**{{ config('app.full_name') }}**
@endcomponent
