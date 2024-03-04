@component('mail::message', ['title' => $title])
Salam Sejahtera Tuan/Puan {{$nama}},<br><br>
Akaun anda di dalam e-Pasca Bencana telah didaftarkan semula. Maklumat lanjut seperti berikut:<br><br>

Nama: <b>{{$nama}}</b><br>
Emel: <b>{{$emel}}</b><br>
Status: <b>Berdaftar</b><br><br>

Sila log masuk ke {{config('app.client_url')}} menggunakan emel dan kata laluan anda yang telah didaftarkan sebelum ini.
Sekiranya terdapat sebarang pertanyaan sila emel ke nadma@nadma.gov.com atau hubungi di talian 03-8870 4800<br><br>

Sekian,<br>
Terima kasih,<br>
**{{ config('app.full_name') }}**
@endcomponent
