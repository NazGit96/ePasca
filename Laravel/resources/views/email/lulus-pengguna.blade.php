@component('mail::message', ['title' => $title])
Salam Sejahtera Tuan/Puan {{$nama}},<br><br>
Permohonan anda sebagai pengguna sistem e-Pasca Bencana telah diluluskan. Maklumat pendaftaran adalah seperti berikut:<br><br>
Nama Pengguna: <b>{{$nama}}</b><br>
Emel: {{$emel}}<br>
Kata Laluan Sementara: {{$password}}<br><br>

Sila gunakan katalaluan sementara yang telah diberikan di halaman log masuk {{config('app.client_url')}} bagi penggunaan pertama kali.
Anda juga diminta untuk menukar katalaluan selepas anda berjaya untuk log masuk.<br><br>

Sekian,<br>
Terima kasih,<br>
**{{ config('app.full_name') }}**
@endcomponent
