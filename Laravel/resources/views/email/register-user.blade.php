@component('mail::message', ['title' => $title])
Salam Sejahtera Tuan/Puan {{$nama}},<br><br>
Terima kasih kerana mendaftar sebagai pengguna e-Pasca Bencana. Maklumat pendaftaran adalah seperti berikut:<br><br>
Nama Pengguna: <b>{{$nama}}</b><br>
Emel: {{$emel}}<br><br>

Pendaftaran anda sedang divarifikasikan oleh pegawai kami.
Maklumat katalaluan sementara akan diberikan selepas maklumat pendaftaran anda diluluskan.<br><br>

Sekian,<br>
Terima kasih,<br>
**{{ config('app.full_name') }}**
@endcomponent
