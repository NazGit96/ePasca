@component('mail::message', ['title' => $title])
Salam Sejahtera Tuan/Puan {{$nama}},<br><br>
Bayaran Waran bagi no. rujukan {{$noWaran}} akan tamat tempoh dalam masa 3 hari lagi. Maklumat lanjut kelulusan seperti berikut:<br><br>

No. Rujukan Waran: <b>{{$noWaran}}</b><br>
Rujukan Surat Surat : <b>{{$rujukanSurat}}</b><br>
Tarikh Tamat: <b>{{date('d-m-Y', strtotime($tarikhTamat))}}</b><br><br>

Sila log masuk ke {{config('app.client_url')}} untuk melakukan tindakan lanjut.<br><br>

Sekian,<br>
Terima kasih,<br>
**{{ config('app.full_name') }}**
@endcomponent