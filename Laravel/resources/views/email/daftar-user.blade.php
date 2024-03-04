@component('mail::message', ['title' => $title])
Salam Sejahtera Tuan/Puan {{$nama}},<br><br>
Tahniah kerana anda telah didaftarkan sebagai pengguna sistem e-Pasca Bencana. Maklumat pendaftaran adalah seperti berikut:<br><br>
Nama Pengguna: <b>{{$nama}}</b><br>
Emel: {{$emel}}<br>
Kata Laluan Sementara: {{$password}}<br><br>

Sila log masuk ke {{config('app.client_url')}} untuk menggunakan sistem.<br><br>

Sekian,<br>
Terima kasih,<br>
**{{ config('app.full_name') }}**
@endcomponent
