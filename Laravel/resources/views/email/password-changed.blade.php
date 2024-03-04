@component('mail::message', ['title' => $title])
Salam Sejahtera Tuan/Puan {{$name}},<br><br>
Anda telah mengemaskini kata laluan untuk akaun <b>{{$emel}}</b> anda. Sekiranya ini adalah anda, maka tiada tindakan lanjut diperlukan.<br><br>
Tetapi jika anda <b>TIDAK</b> melakukan perubahan kata laluan, sila segera tetapkan semula kata laluan akaun anda. Anda dinasihatkan untuk menggunakan kata laluan yang kuat dan unik untuk akaun anda.

Sekian,<br>
Terima kasih,<br>
**{{ config('app.full_name') }}**
@endcomponent
