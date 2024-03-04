@component('mail::message', ['title' => $title])
Salam Sejahtera Tuan/Puan {{$namaAdmin}},<br><br>
Ini adalah emel permohonan agensi bagi tindakan lanjut pihak tuan/puan. Berikut adalah maklumat pendaftaran sebagai rujukan:<br><br>

Status Pendaftaran: Permohonan<br>
Nama Wakil: {{$namaWakil}}<br>
Agensi: {{$agensi}}<br>
Jawatan: {{$jawatan}}<br><br>

Sila log masuk ke {{config('app.client_url')}} untuk melakukan tindakan lanjut.<br><br>

Sekian,<br>
Terima kasih,<br>
**{{ config('app.full_name') }}**
@endcomponent
