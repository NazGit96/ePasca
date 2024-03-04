@component('mail::message', ['title' => $title])
Salam Sejahtera Tuan/Puan {{$nama}},<br><br>
Akaun e-Pasca Bencana anda telah tidak aktif. Maklumat status akaun anda adalah seperti berikut:<br><br>

Nama: <b>{{$nama}}</b><br>
Emel: {{$emel}}<br>
Sebab Tidak Aktif: {{$catatan}}<br><br>

Sekiranya terdapat sebarang pertanyaan sila emel ke nadma@nadma.gov.com atau hubungi di talian 03-8870 4800<br><br>

Sekian,<br>
Terima kasih,<br>
**{{ config('app.full_name') }}**
@endcomponent
