@component('mail::message', ['title' => $title])
Salam Sejahtera Tuan/Puan {{$nama}},<br><br>
Surat Kuasa Belanja (SKB) bagi no. rujukan {{$noSkb}} akan tamat tempoh dalam masa 3 hari lagi. Maklumat lanjut kelulusan seperti berikut:<br><br>

No. Rujukan SKB: <b>{{$noSkb}}</b><br>
Rujukan Surat Surat : <b>{{$rujukanSurat}}</b><br>
Tarikh Tamat: <b>{{date('d-m-Y', strtotime($tarikhTamat))}}</b><br><br>

Sila log masuk ke {{config('app.client_url')}} untuk melakukan tindakan lanjut.<br><br>

Sekian,<br>
Terima kasih,<br>
**{{ config('app.full_name') }}**
@endcomponent
