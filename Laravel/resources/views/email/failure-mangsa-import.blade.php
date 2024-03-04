@component('mail::message', ['title' => $title])
Salam Sejahtera Tuan/Puan {{$nama}},<br><br>
Disertakan bersama emel ini adalah laporan ralat({{$error}}) berkenaan data import mangsa. <br><br>
Sila baiki dan muatnaik kembali data yang ralat sahaja.<br><br>

Sekian,<br>
Terima kasih,<br>
**{{ config('app.full_name') }}**
@endcomponent
