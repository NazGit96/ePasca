@component('mail::message', ['title' => $title])
Salam Sejahtera Tuan/Puan {{$nama}},<br><br>
Maklumat pendaftaran emel dan kata laluan anda telah dikemaskini dan ditetapkan semula. Maklumat lanjut seperti berikut:<br><br>

Dikemaskini Oleh: <b>{{$admin}}</b><br>
Emel Lama: <b>{{$emel}}</b><br>
Emel Baru: <b>{{$changeEmel}}</b><br>
Kata Laluan Sementara: {{$password}}<br><br>

Sila log masuk ke {{config('app.client_url')}} untuk menggunakan sistem.<br><br>

Sekian,<br>
Terima kasih,<br>
**{{ config('app.full_name') }}**
@endcomponent
