<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DashboardTabungController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\RefNegeriController;
use App\Http\Controllers\RefAgamaController;
use App\Http\Controllers\RefAgensiController;
use App\Http\Controllers\RefBantuanController;
use App\Http\Controllers\RefBencanaController;
use App\Http\Controllers\RefDaerahController;
use App\Http\Controllers\RefDunController;
use App\Http\Controllers\RefJenisBencanaController;
use App\Http\Controllers\RefJenisPertanianController;
use App\Http\Controllers\RefKementerianController;
use App\Http\Controllers\RefKerosakanController;
use App\Http\Controllers\RefMukimController;
use App\Http\Controllers\RefParlimenController;
use App\Http\Controllers\RefPelaksanaController;
use App\Http\Controllers\RefPemilikController;
use App\Http\Controllers\RefPerananController;
use App\Http\Controllers\RefPindahController;
use App\Http\Controllers\RefPinjamanPerniagaanController;
use App\Http\Controllers\RefSektorController;
use App\Http\Controllers\RefStatusKemajuanController;
use App\Http\Controllers\RefStatusKerosakanController;
use App\Http\Controllers\RefSumberDanaController;
use App\Http\Controllers\RefSumberPeruntukanController;
use App\Http\Controllers\RefTapakRumahController;
use App\Http\Controllers\RefWarganegaraController;
use App\Http\Controllers\RefHubunganController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\RefRujukanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MangsaController;
use App\Http\Controllers\MangsaRumahController;
use App\Http\Controllers\MangsaPinjamanController;
use App\Http\Controllers\MangsaAntarabangsaController;
use App\Http\Controllers\MangsaPertanianController;
use App\Http\Controllers\MangsaBantuanController;
use App\Http\Controllers\MangsaAirController;
use App\Http\Controllers\MangsaWangIhsanController;
use App\Http\Controllers\MangsaBencanaController;
use App\Http\Controllers\MangsaKerosakanController;
use App\Http\Controllers\TabungController;
use App\Http\Controllers\TabungKelulusanController;
use App\Http\Controllers\TabungPeruntukanController;
use App\Http\Controllers\TabungBayaranSkbController;
use App\Http\Controllers\TabungBayaranSkbBulananController;
use App\Http\Controllers\TabungBayaranWaranController;
use App\Http\Controllers\TabungBayaranWaranBulananController;
use App\Http\Controllers\TabungBayaranTerusController;
use App\Http\Controllers\TabungBwiController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\TabungKelulusanAmbilanController;
use App\Http\Controllers\TabungBwiBayaranController;
use App\Http\Controllers\TabungBwiKawasanController;
use App\Http\Controllers\RefBencanaNegeriController;
use App\Http\Controllers\RefJenisBwiController;
use App\Http\Controllers\RefJenisBayaranController;
use App\Http\Controllers\RefKategoriBayaranController;
use App\Http\Controllers\RefJenisPeruntukanController;
use App\Http\Controllers\RefKadarBwiController;
use App\Http\Controllers\RefPengumumanController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['prefix' => 'auth', 'middleware' => 'api'], function () {
    Route::post('registerUser', [AuthController::class, 'registerUser']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('profile', [AuthController::class, 'profile']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('forgotPassword', [AuthController::class, 'forgotPassword']);
    Route::get('verifyCode', [AuthController::class, 'verifyCode']);
    Route::post('resetPassword', [AuthController::class, 'resetPassword']);
});

Route::group(['prefix' => 'auth', 'middleware' => ['api', 'jwt.verify']], function () {
    Route::post('changePassword', [AuthController::class, 'changePassword']);
});

Route::group(['prefix' => 'file'], function() {
    Route::get('downloadTempFile', [FileController::class, 'downloadTempFile']);
});

Route::group(['prefix' => 'dashboard', 'middleware' => ['jwt.verify']], function () {
    Route::get('getJumlahKematianCovid19', [DashboardController::class, 'getJumlahKematianCovid19']);
    Route::get('getJumlahRM100Covid19', [DashboardController::class, 'getJumlahRM100Covid19']);
    Route::get('getJumlahBantuan', [DashboardController::class, 'getJumlahBantuan']);
    Route::get('getJumlahBantuanByNegeri', [DashboardController::class, 'getJumlahBantuanByNegeri']);
    Route::get('getJumlahMangsaBencanaByNegeri', [DashboardController::class, 'getJumlahMangsaBencanaByNegeri']);
});

Route::group(['prefix' => 'dashboardTabung', 'middleware' => ['api', 'jwt.verify', 'permission:Halaman.Tabung']], function () {
    Route::get('getTotalTabungCard', [DashboardTabungController::class, 'getTotalTabungCard'])->middleware('permission:Halaman.Tabung.Dashboard');
    Route::get('getTotalBayaranTerusByMonth', [DashboardTabungController::class, 'getTotalBayaranTerusByMonth'])->middleware('permission:Halaman.Tabung.Dashboard');
    Route::get('getTotalSkbByMonth', [DashboardTabungController::class, 'getTotalSkbByMonth'])->middleware('permission:Halaman.Tabung.Dashboard');
    Route::get('getBelanjaTanggunganByTabung', [DashboardTabungController::class, 'getBelanjaTanggunganByTabung'])->middleware('permission:Halaman.Tabung.Dashboard');
});


Route::group(['prefix' => 'laporan', 'middleware' => ['api', 'jwt.verify', 'permission:Halaman.Laporan']], function () {
    Route::get('getKosBantuanByJenisBantuan', [LaporanController::class, 'getKosBantuanByJenisBantuan'])->middleware('permission:Halaman.Laporan.Ringkasan');
    Route::get('getSumberDanaRumah', [LaporanController::class, 'getSumberDanaRumah'])->middleware('permission:Halaman.Laporan.Ringkasan');
    Route::get('getAllMangsa', [LaporanController::class, 'getAllMangsa'])->middleware('permission:Halaman.Laporan.Mangsa');
    Route::get('exportAllMangsaToExcel', [LaporanController::class, 'exportAllMangsaToExcel'])->middleware('permission:Halaman.Laporan.Mangsa');
    Route::get('getAllMangsaBelumTerimaBantuan', [LaporanController::class, 'getAllMangsaBelumTerimaBantuan'])->middleware('permission:Halaman.Laporan.Mangsa');
    Route::get('exportAllMangsaBelumTerimaBantuanToExcel', [LaporanController::class, 'exportAllMangsaBelumTerimaBantuanToExcel'])->middleware('permission:Halaman.Laporan.Mangsa');
    Route::get('getAllMangsaBantuanLain', [LaporanController::class, 'getAllMangsaBantuanLain'])->middleware('permission:Halaman.Laporan.Mangsa.BantuanLain');
    Route::get('exportAllMangsaBantuanLainToExcel', [LaporanController::class, 'exportAllMangsaBantuanLainToExcel'])->middleware('permission:Halaman.Laporan.Mangsa.BantuanLain');
    Route::get('getAllMangsaBantuanAntarabangsa', [LaporanController::class, 'getAllMangsaBantuanAntarabangsa'])->middleware('permission:Halaman.Laporan.Mangsa.BantuanAntarabangsa');
    Route::get('exportAllMangsaBantuanAntarabangsaToExcel', [LaporanController::class, 'exportAllMangsaBantuanAntarabangsaToExcel'])->middleware('permission:Halaman.Laporan.Mangsa.BantuanAntarabangsa');
    Route::get('getAllMangsaBantuanPinjaman', [LaporanController::class, 'getAllMangsaBantuanPinjaman'])->middleware('permission:Halaman.Laporan.Mangsa.BantuanPinjaman');
    Route::get('exportAllMangsaBantuanPinjamanToExcel', [LaporanController::class, 'exportAllMangsaBantuanPinjamanToExcel'])->middleware('permission:Halaman.Laporan.Mangsa.BantuanPinjaman');
    Route::get('getAllMangsaBantuanPertanian', [LaporanController::class, 'getAllMangsaBantuanPertanian'])->middleware('permission:Halaman.Laporan.Mangsa.BantuanPertanian');
    Route::get('exportAllMangsaBantuanPertanianToExcel', [LaporanController::class, 'exportAllMangsaBantuanPertanianToExcel'])->middleware('permission:Halaman.Laporan.Mangsa.BantuanPertanian');
    Route::get('getAllMangsaBantuanRumah', [LaporanController::class, 'getAllMangsaBantuanRumah'])->middleware('permission:Halaman.Laporan.Mangsa.BantuanRumah');
    Route::get('exportAllMangsaBantuanRumahToExcel', [LaporanController::class, 'exportAllMangsaBantuanRumahToExcel'])->middleware('permission:Halaman.Laporan.Mangsa.BantuanRumah');
    Route::get('getAllMangsaBantuanWangIhsan', [LaporanController::class, 'getAllMangsaBantuanWangIhsan'])->middleware('permission:Halaman.Laporan.Mangsa.BWI');
    Route::get('exportAllMangsaBantuanWangIhsanToExcel', [LaporanController::class, 'exportAllMangsaBantuanWangIhsanToExcel'])->middleware('permission:Halaman.Laporan.Mangsa.BWI');
    Route::get('getAllLaporanBayaranTerus', [LaporanController::class, 'getAllLaporanBayaranTerus'])->middleware('permission:Halaman.Laporan.Tabung.Terus');
    Route::get('exportAllBayaranTerusToExcel', [LaporanController::class, 'exportAllBayaranTerusToExcel'])->middleware('permission:Halaman.Laporan.Tabung.Terus');
    Route::get('getAllLaporanBwi', [LaporanController::class, 'getAllLaporanBwi'])->middleware('permission:Halaman.Laporan.Tabung.BWI');
    Route::get('exportAllLaporanBwiToExcel', [LaporanController::class, 'exportAllLaporanBwiToExcel'])->middleware('permission:Halaman.Laporan.Tabung.BWI');
    Route::get('getAllLaporanBwiBencanaKir', [LaporanController::class, 'getAllLaporanBwiBencanaKir'])->middleware('permission:Halaman.Laporan.Tabung.BWI');
    Route::get('exportAllLaporanBwiBencanaKirToExcel', [LaporanController::class, 'exportAllLaporanBwiBencanaKirToExcel'])->middleware('permission:Halaman.Laporan.Tabung.BWI');
    Route::get('getAllLaporanBwiByNegeri', [LaporanController::class, 'getAllLaporanBwiByNegeri'])->middleware('permission:Halaman.Laporan.Tabung.BWI');
    Route::get('exportAllLaporanBwiByNegeriToExcel', [LaporanController::class, 'exportAllLaporanBwiByNegeriToExcel'])->middleware('permission:Halaman.Laporan.Tabung.BWI');
    Route::get('getAllLaporanBwiKematian', [LaporanController::class, 'getAllLaporanBwiKematian'])->middleware('permission:Halaman.Laporan.Tabung.BWI');
    Route::get('exportAllLaporanBwiKematianToExcel', [LaporanController::class, 'exportAllLaporanBwiKematianToExcel'])->middleware('permission:Halaman.Laporan.Tabung.BWI');
    Route::get('getAllLaporanKelulusan', [LaporanController::class, 'getAllLaporanKelulusan'])->middleware('permission:Halaman.Laporan.Tabung.Kelulusan');
    Route::get('exportAllLaporanKelulusanToExcel', [LaporanController::class, 'exportAllLaporanKelulusanToExcel'])->middleware('permission:Halaman.Laporan.Tabung.Kelulusan');
    Route::get('getAllLaporanSkb', [LaporanController::class, 'getAllLaporanSkb'])->middleware('permission:Halaman.Laporan.Tabung.SKB');
    Route::get('exportAllLaporanSkbToExcel', [LaporanController::class, 'exportAllLaporanSkbToExcel'])->middleware('permission:Halaman.Laporan.Tabung.SKB');
    Route::get('getAllLaporanWaran', [LaporanController::class, 'getAllLaporanWaran'])->middleware('permission:Halaman.Laporan.Tabung.Waran');
    Route::get('exportAllLaporanWaranToExcel', [LaporanController::class, 'exportAllLaporanWaranToExcel'])->middleware('permission:Halaman.Laporan.Tabung.Waran');
    Route::get('getAllRingkasanLaporanBwiByNegeri', [LaporanController::class, 'getAllRingkasanLaporanBwiByNegeri']);
    Route::get('getBilBwiKirByJenisBayaran', [LaporanController::class, 'getBilBwiKirByJenisBayaran']);
});

Route::group(['prefix' => 'session', 'middleware' => ['jwt.verify']], function() {
    Route::get('getProfil', [SessionController::class, 'getProfil']);
    Route::put('updateProfil', [SessionController::class, 'updateProfil']);
    Route::put('changePassword', [SessionController::class, 'changePassword']);
    Route::post('uploadGambarProfil', [SessionController::class, 'uploadGambarProfil']);
});

Route::group(['prefix' => 'user', 'middleware' => ['api', 'jwt.verify', 'permission:Halaman.Pengguna']], function () {
    Route::get('getAllUser', [UserController::class, 'getAllUser']);
    Route::get('exportAllUserToExcel', [UserController::class, 'exportAllUserToExcel']);
    Route::get('getAllPermohonanUser', [UserController::class, 'getAllPermohonanUser']);
    Route::post('ApprovedUser', [UserController::class, 'ApprovedUser'])->middleware('permission:Halaman.Pengguna.Tambah,Halaman.Pengguna.Edit');
    Route::get('getUserForEdit', [UserController::class, 'getUserForEdit']);
    Route::post('createOrEdit', [UserController::class, 'createOrEdit'])->middleware('permission:Halaman.Pengguna.Tambah,Halaman.Pengguna.Edit');
    Route::post('changeEmelAndPassword', [UserController::class, 'changeEmelAndPassword'])->middleware('permission:Halaman.Pengguna.Tambah,Halaman.Pengguna.Edit');
    Route::delete('delete', [UserController::class, 'delete'])->middleware('permission:Halaman.Pengguna.Hapus');
});

Route::prefix('refNegeri')->group(function () {
    Route::get('getAll', [RefNegeriController::class, 'getAll']);
    Route::get('getRefNegeriForEdit', [RefNegeriController::class, 'getRefNegeriForEdit']);
    Route::get('getRefNegeriForDropdown', [RefNegeriController::class, 'getRefNegeriForDropdown']);
    Route::post('createOrEdit', [RefNegeriController::class, 'createOrEdit'])->middleware(['api', 'jwt.verify','permission:Halaman.Tetapan.Negeri']);
});

Route::prefix('refAgama')->group(function () {
    Route::get('getAll', [RefAgamaController::class, 'getAll']);
    Route::get('getRefAgamaForEdit', [RefAgamaController::class, 'getRefAgamaForEdit']);
    Route::get('getRefAgamaForDropdown', [RefAgamaController::class, 'getRefAgamaForDropdown']);
    Route::post('createOrEdit', [RefAgamaController::class, 'createOrEdit']);
});

Route::prefix('refAgensi')->group(function () {
    Route::get('getAll', [RefAgensiController::class, 'getAll']);
    Route::get('getRefAgensiForEdit', [RefAgensiController::class, 'getRefAgensiForEdit']);
    Route::get('getRefAgensiForDropdown', [RefAgensiController::class, 'getRefAgensiForDropdown']);
    Route::post('createOrEdit', [RefAgensiController::class, 'createOrEdit'])->middleware(['api', 'jwt.verify','permission:Halaman.Tetapan.Agensi']);
});

Route::prefix('refBantuan')->group(function () {
    Route::get('getAll', [RefBantuanController::class, 'getAll']);
    Route::get('getRefBantuanForEdit', [RefBantuanController::class, 'getRefBantuanForEdit']);
    Route::get('getRefBantuanForDropdown', [RefBantuanController::class, 'getRefBantuanForDropdown']);
    Route::post('createOrEdit', [RefBantuanController::class, 'createOrEdit'])->middleware(['api', 'jwt.verify','permission:Halaman.Tetapan.JenisBantuan']);
});

Route::group(['prefix' => 'refBencana', 'middleware' => ['api']], function () {
    Route::get('getAll', [RefBencanaController::class, 'getAll']);
    Route::get('getRefBencanaForEdit', [RefBencanaController::class, 'getRefBencanaForEdit']);
    Route::get('getRefBencanaForDropdown', [RefBencanaController::class, 'getRefBencanaForDropdown']);
    Route::post('createOrEdit', [RefBencanaController::class, 'createOrEdit'])->middleware('permission:Halaman.Bencana.Tambah,Halaman.Bencana.Edit');
    Route::delete('delete', [RefBencanaController::class, 'delete'])->middleware('permission:Halaman.Bencana.Hapus');
});

Route::prefix('refKadarBwi')->group(function () {
    Route::get('getAll', [RefKadarBwiController::class, 'getAll']);
    Route::get('getRefKadarBwiForEdit', [RefKadarBwiController::class, 'getRefKadarBwiForEdit']);
    Route::get('getRefKadarBwiForDropdown', [RefKadarBwiController::class, 'getRefKadarBwiForDropdown']);
    Route::post('createOrEdit', [RefKadarBwiController::class, 'createOrEdit'])->middleware(['api', 'jwt.verify','permission:Halaman.Tetapan.KadarBwi']);
});

Route::prefix('refDaerah')->group(function () {
    Route::get('getAll', [RefDaerahController::class, 'getAll']);
    Route::get('getRefDaerahForEdit', [RefDaerahController::class, 'getRefDaerahForEdit']);
    Route::get('getRefDaerahForDropdown', [RefDaerahController::class, 'getRefDaerahForDropdown']);
    Route::post('createOrEdit', [RefDaerahController::class, 'createOrEdit'])->middleware(['api', 'jwt.verify','permission:Halaman.Tetapan.Daerah']);
});

Route::prefix('refDun')->group(function () {
    Route::get('getAll', [RefDunController::class, 'getAll']);
    Route::get('getRefDunForEdit', [RefDunController::class, 'getRefDunForEdit']);
    Route::get('getRefDunForDropdown', [RefDunController::class, 'getRefDunForDropdown']);
    Route::post('createOrEdit', [RefDunController::class, 'createOrEdit'])->middleware(['api', 'jwt.verify','permission:Halaman.Tetapan.Dun']);
});

Route::prefix('refJenisBencana')->group(function () {
    Route::get('getAll', [RefJenisBencanaController::class, 'getAll']);
    Route::get('getRefJenisBencanaForEdit', [RefJenisBencanaController::class, 'getRefJenisBencanaForEdit']);
    Route::get('getRefJenisBencanaForDropdown', [RefJenisBencanaController::class, 'getRefJenisBencanaForDropdown']);
    Route::post('createOrEdit', [RefJenisBencanaController::class, 'createOrEdit'])->middleware(['api', 'jwt.verify','permission:Halaman.Tetapan.KategoriBencana']);
});

Route::prefix('refJenisPertanian')->group(function () {
    Route::get('getAll', [RefJenisPertanianController::class, 'getAll']);
    Route::get('getRefJenisPertanianForEdit', [RefJenisPertanianController::class, 'getRefJenisPertanianForEdit']);
    Route::get('getRefJenisPertanianForDropdown', [RefJenisPertanianController::class, 'getRefJenisPertanianForDropdown']);
    Route::post('createOrEdit', [RefJenisPertanianController::class, 'createOrEdit']);
});

Route::prefix('refKementerian')->group(function () {
    Route::get('getAll', [RefKementerianController::class, 'getAll']);
    Route::get('getRefKementerianForEdit', [RefKementerianController::class, 'getRefKementerianForEdit']);
    Route::get('getRefKementerianForDropdown', [RefKementerianController::class, 'getRefKementerianForDropdown']);
    Route::post('createOrEdit', [RefKementerianController::class, 'createOrEdit'])->middleware(['api', 'jwt.verify','permission:Halaman.Tetapan.Kementerian']);
});

Route::prefix('refKerosakan')->group(function () {
    Route::get('getAll', [RefKerosakanController::class, 'getAll']);
    Route::get('getRefKerosakanForEdit', [RefKerosakanController::class, 'getRefKerosakanForEdit']);
    Route::get('getRefKerosakanForDropdown', [RefKerosakanController::class, 'getRefKerosakanForDropdown']);
    Route::post('createOrEdit', [RefKerosakanController::class, 'createOrEdit'])->middleware(['api', 'jwt.verify','permission:Halaman.Tetapan.KerosakanRumah']);
});

Route::prefix('refMukim')->group(function () {
    Route::get('getAll', [RefMukimController::class, 'getAll']);
    Route::get('getRefMukimForEdit', [RefMukimController::class, 'getRefMukimForEdit']);
    Route::get('getRefMukimForDropdown', [RefMukimController::class, 'getRefMukimForDropdown']);
    Route::post('createOrEdit', [RefMukimController::class, 'createOrEdit']);
});

Route::prefix('refParlimen')->group(function () {
    Route::get('getAll', [RefParlimenController::class, 'getAll']);
    Route::get('getRefParlimenForEdit', [RefParlimenController::class, 'getRefParlimenForEdit']);
    Route::get('getRefParlimenForDropdown', [RefParlimenController::class, 'getRefParlimenForDropdown']);
    Route::post('createOrEdit', [RefParlimenController::class, 'createOrEdit'])->middleware(['api', 'jwt.verify','permission:Halaman.Tetapan.Parlimen']);
});

Route::prefix('refPelaksana')->group(function () {
    Route::get('getAll', [RefPelaksanaController::class, 'getAll']);
    Route::get('getRefPelaksanaForEdit', [RefPelaksanaController::class, 'getRefPelaksanaForEdit']);
    Route::get('getRefPelaksanaForDropdown', [RefPelaksanaController::class, 'getRefPelaksanaForDropdown']);
    Route::post('createOrEdit', [RefPelaksanaController::class, 'createOrEdit'])->middleware(['api', 'jwt.verify','permission:Halaman.Tetapan.Pelaksana']);
});

Route::prefix('refPemilik')->group(function () {
    Route::get('getAll', [RefPemilikController::class, 'getAll']);
    Route::get('getRefPemilikForEdit', [RefPemilikController::class, 'getRefPemilikForEdit']);
    Route::get('getRefPemilikForDropdown', [RefPemilikController::class, 'getRefPemilikForDropdown']);
    Route::post('createOrEdit', [RefPemilikController::class, 'createOrEdit'])->middleware(['api', 'jwt.verify','permission:Halaman.Tetapan.PemilikProjek']);
});

Route::prefix('refPengumuman')->group(function () {
    Route::get('getAll', [RefPengumumanController::class, 'getAll']);
    Route::get('getAllPengumumanForView', [RefPengumumanController::class, 'getAllPengumumanForView']);
    Route::get('getRefPengumumanForEdit', [RefPengumumanController::class, 'getRefPengumumanForEdit']);
    Route::get('getRefPengumumanForDropdown', [RefPengumumanController::class, 'getRefPengumumanForDropdown']);
    Route::post('createOrEdit', [RefPengumumanController::class, 'createOrEdit'])->middleware(['api', 'jwt.verify','permission:Halaman.Tetapan.Pengumuman']);
});

Route::prefix('refPeranan')->group(function () {
    Route::get('getAll', [RefPerananController::class, 'getAll']);
    Route::get('getRefPerananForEdit', [RefPerananController::class, 'getRefPerananForEdit']);
    Route::get('getRefPerananForDropdown', [RefPerananController::class, 'getRefPerananForDropdown']);
    Route::post('createOrEdit', [RefPerananController::class, 'createOrEdit'])->middleware(['api', 'jwt.verify','permission:Halaman.Tetapan.Peranan']);
    Route::get('getAllRefCapaian', [RefPerananController::class, 'getAllRefCapaian']);
});

Route::prefix('refPindah')->group(function () {
    Route::get('getAll', [RefPindahController::class, 'getAll']);
    Route::get('getRefPindahForEdit', [RefPindahController::class, 'getRefPindahForEdit']);
    Route::get('getRefPindahForDropdown', [RefPindahController::class, 'getRefPindahForDropdown']);
    Route::post('createOrEdit', [RefPindahController::class, 'createOrEdit'])->middleware(['api', 'jwt.verify','permission:Halaman.Tetapan.StatusBerpindah']);
});

Route::prefix('refPinjamanPerniagaan')->group(function () {
    Route::get('getAll', [RefPinjamanPerniagaanController::class, 'getAll']);
    Route::get('getRefPinjamanPerniagaanForEdit', [RefPinjamanPerniagaanController::class, 'getRefPinjamanPerniagaanForEdit']);
    Route::get('getRefPinjamanPerniagaanForDropdown', [RefPinjamanPerniagaanController::class, 'getRefPinjamanPerniagaanForDropdown']);
    Route::post('createOrEdit', [RefPinjamanPerniagaanController::class, 'createOrEdit'])->middleware(['api', 'jwt.verify','permission:Halaman.Tetapan.Pinjaman']);
});

Route::prefix('refSektor')->group(function () {
    Route::get('getAll', [RefSektorController::class, 'getAll']);
    Route::get('getRefSektorForEdit', [RefSektorController::class, 'getRefSektorForEdit']);
    Route::get('getRefSektorForDropdown', [RefSektorController::class, 'getRefSektorForDropdown']);
    Route::post('createOrEdit', [RefSektorController::class, 'createOrEdit']);
});

Route::prefix('refStatusKemajuan')->group(function () {
    Route::get('getAll', [RefStatusKemajuanController::class, 'getAll']);
    Route::get('getRefStatusKemajuanForEdit', [RefStatusKemajuanController::class, 'getRefStatusKemajuanForEdit']);
    Route::get('getRefStatusKemajuanForDropdown', [RefStatusKemajuanController::class, 'getRefStatusKemajuanForDropdown']);
    Route::post('createOrEdit', [RefStatusKemajuanController::class, 'createOrEdit']);
});

Route::prefix('refStatusKerosakan')->group(function () {
    Route::get('getAll', [RefStatusKerosakanController::class, 'getAll']);
    Route::get('getRefStatusKerosakanForEdit', [RefStatusKerosakanController::class, 'getRefStatusKerosakanForEdit']);
    Route::get('getRefStatusKerosakanForDropdown', [RefStatusKerosakanController::class, 'getRefStatusKerosakanForDropdown']);
    Route::post('createOrEdit', [RefStatusKerosakanController::class, 'createOrEdit'])->middleware(['api', 'jwt.verify','permission:Halaman.Tetapan.KerosakanRumah']);
});

Route::prefix('refSumberDana')->group(function () {
    Route::get('getAll', [RefSumberDanaController::class, 'getAll']);
    Route::get('getRefSumberDanaForEdit', [RefSumberDanaController::class, 'getRefSumberDanaForEdit']);
    Route::get('getRefSumberDanaForDropdown', [RefSumberDanaController::class, 'getRefSumberDanaForDropdown']);
    Route::post('createOrEdit', [RefSumberDanaController::class, 'createOrEdit'])->middleware(['api', 'jwt.verify','permission:Halaman.Tetapan.SumberDana']);
});

Route::prefix('refSumberPeruntukan')->group(function () {
    Route::get('getAll', [RefSumberPeruntukanController::class, 'getAll']);
    Route::get('getRefSumberPeruntukanForEdit', [RefSumberPeruntukanController::class, 'getRefSumberPeruntukanForEdit']);
    Route::get('getRefSumberPeruntukanForDropdown', [RefSumberPeruntukanController::class, 'getRefSumberPeruntukanForDropdown']);
    Route::post('createOrEdit', [RefSumberPeruntukanController::class, 'createOrEdit']);
});

Route::prefix('refTapakRumah')->group(function () {
    Route::get('getAll', [RefTapakRumahController::class, 'getAll']);
    Route::get('getRefTapakRumahForEdit', [RefTapakRumahController::class, 'getRefTapakRumahForEdit']);
    Route::get('getRefTapakRumahForDropdown', [RefTapakRumahController::class, 'getRefTapakRumahForDropdown']);
    Route::post('createOrEdit', [RefTapakRumahController::class, 'createOrEdit'])->middleware(['api', 'jwt.verify','permission:Halaman.Tetapan.PemilikProjekRumah']);
});

Route::prefix('refWarganegara')->group(function () {
    Route::get('getAll', [RefWarganegaraController::class, 'getAll']);
    Route::get('getRefWarganegaraForEdit', [RefWarganegaraController::class, 'getRefWarganegaraForEdit']);
    Route::get('getRefWarganegaraForDropdown', [RefWarganegaraController::class, 'getRefWarganegaraForDropdown']);
    Route::post('createOrEdit', [RefWarganegaraController::class, 'createOrEdit']);
});

Route::prefix('refHubungan')->group(function () {
    Route::get('getAll', [RefHubunganController::class, 'getAll']);
    Route::get('getRefHubunganForEdit', [RefHubunganController::class, 'getRefHubunganForEdit']);
    Route::get('getRefHubunganForDropdown', [RefHubunganController::class, 'getRefHubunganForDropdown']);
    Route::post('createOrEdit', [RefHubunganController::class, 'createOrEdit'])->middleware(['api', 'jwt.verify','permission:Halaman.Tetapan.Hubungan']);
});

Route::group(['prefix' => 'refRujukan', 'middleware' => ['api', 'jwt.verify', 'permission:Halaman.Tetapan.Rujukan']], function () {
    Route::get('getAll', [RefRujukanController::class, 'getAll']);
    Route::get('getRefRujukanForEdit', [RefRujukanController::class, 'getRefRujukanForEdit']);
    Route::post('createOrEdit', [RefRujukanController::class, 'createOrEdit']);
    Route::post('uploadFail', [RefRujukanController::class, 'uploadFail']);
});

Route::group(['prefix' => 'mangsa', 'middleware' => ['api', 'jwt.verify', 'permission:Halaman.Mangsa']], function () {
    Route::get('getAll', [MangsaController::class, 'getAll']);
    Route::get('getMangsaForEdit', [MangsaController::class, 'getMangsaForEdit']);
    Route::get('getMangsaForDropdown', [MangsaController::class, 'getMangsaForDropdown']);
    Route::post('createOrEdit', [MangsaController::class, 'createOrEdit'])->middleware('permission:Halaman.Mangsa.Tambah,Halaman.Mangsa.Edit');
    Route::post('multipleVerifikasi', [MangsaController::class, 'multipleVerifikasi'])->middleware('permission:Halaman.Mangsa.Tambah,Halaman.Mangsa.Edit');
    Route::post('uploadGambarProfilMangsa', [MangsaController::class, 'uploadGambarProfilMangsa'])->middleware('permission:Halaman.Mangsa.Tambah,Halaman.Mangsa.Edit');
    Route::delete('delete', [MangsaController::class, 'delete'])->middleware('permission:Halaman.Mangsa.Hapus');
});

Route::group(['prefix' => 'excel', 'middleware' => ['api', 'jwt.verify']], function () {
    Route::post('uploadMangsa', [MangsaController::class, 'uploadMangsa']);

});

Route::group(['prefix' => 'mangsaRumah', 'middleware' => ['api', 'jwt.verify', 'permission:Halaman.Mangsa.BantuanRumah']], function () {
    Route::get('getAll', [MangsaRumahController::class, 'getAll']);
    Route::get('getAllByIdMangsa', [MangsaRumahController::class, 'getAllByIdMangsa']);
    Route::get('getMangsaRumahForEdit', [MangsaRumahController::class, 'getMangsaRumahForEdit']);
    Route::post('createOrEdit', [MangsaRumahController::class, 'createOrEdit'])->middleware('permission:Halaman.Mangsa.BantuanRumah.Tambah,Halaman.Mangsa.BantuanRumah.Edit');
    Route::delete('delete', [MangsaRumahController::class, 'delete'])->middleware('permission:Halaman.Mangsa.BantuanRumah.Hapus');
});

Route::group(['prefix' => 'mangsaPinjaman', 'middleware' => ['api', 'jwt.verify', 'permission:Halaman.Mangsa.BantuanPinjaman']], function () {
    Route::get('getAll', [MangsaPinjamanController::class, 'getAll']);
    Route::get('getAllByIdMangsa', [MangsaPinjamanController::class, 'getAllByIdMangsa']);
    Route::get('getMangsaPinjamanForEdit', [MangsaPinjamanController::class, 'getMangsaPinjamanForEdit']);
    Route::post('createOrEdit', [MangsaPinjamanController::class, 'createOrEdit'])->middleware('permission:Halaman.Mangsa.BantuanPinjaman.Tambah,Halaman.Mangsa.BantuanPinjaman.Edit');
    Route::delete('delete', [MangsaPinjamanController::class, 'delete'])->middleware('permission:Halaman.Mangsa.BantuanPinjaman.Hapus');
});

Route::group(['prefix' => 'mangsaAntarabangsa', 'middleware' => ['api', 'jwt.verify', 'permission:Halaman.Mangsa.BantuanAntarabangsa']], function () {
    Route::get('getAll', [MangsaAntarabangsaController::class, 'getAll']);
    Route::get('getAllByIdMangsa', [MangsaAntarabangsaController::class, 'getAllByIdMangsa']);
    Route::get('getMangsaAntarabangsaForEdit', [MangsaAntarabangsaController::class, 'getMangsaAntarabangsaForEdit']);
    Route::post('createOrEdit', [MangsaAntarabangsaController::class, 'createOrEdit'])->middleware('permission:Halaman.Mangsa.BantuanAntarabangsa.Tambah,Halaman.Mangsa.BantuanAntarabangsa.Edit');
    Route::delete('delete', [MangsaAntarabangsaController::class, 'delete'])->middleware('permission:Halaman.Mangsa.BantuanAntarabangsa.Hapus');
});

Route::group(['prefix' => 'mangsaPertanian', 'middleware' => ['api', 'jwt.verify', 'permission:Halaman.Mangsa.BantuanPertanian']], function () {
    Route::get('getAll', [MangsaPertanianController::class, 'getAll']);
    Route::get('getAllByIdMangsa', [MangsaPertanianController::class, 'getAllByIdMangsa']);
    Route::get('getMangsaPertanianForEdit', [MangsaPertanianController::class, 'getMangsaPertanianForEdit']);
    Route::post('createOrEdit', [MangsaPertanianController::class, 'createOrEdit'])->middleware('permission:Halaman.Mangsa.BantuanPertanian.Tambah,Halaman.Mangsa.BantuanPertanian.Edit');
    Route::delete('delete', [MangsaPertanianController::class, 'delete'])->middleware('permission:Halaman.Mangsa.BantuanPertanian.Hapus');
});

Route::group(['prefix' => 'mangsaBantuan', 'middleware' => ['api', 'jwt.verify', 'permission:Halaman.Mangsa.BantuanLain']], function () {
    Route::get('getAll', [MangsaBantuanController::class, 'getAll']);
    Route::get('getAllByIdMangsa', [MangsaBantuanController::class, 'getAllByIdMangsa']);
    Route::get('getMangsaBantuanForEdit', [MangsaBantuanController::class, 'getMangsaBantuanForEdit']);
    Route::post('createOrEdit', [MangsaBantuanController::class, 'createOrEdit'])->middleware('permission:Halaman.Mangsa.BantuanLain.Tambah,Halaman.Mangsa.BantuanLain.Edit');
    Route::delete('delete', [MangsaBantuanController::class, 'delete'])->middleware('permission:Halaman.Mangsa.BantuanLain.Hapus');
});

Route::group(['prefix' => 'mangsaAir', 'middleware' => ['api', 'jwt.verify', 'permission:Halaman.Mangsa.Air']], function () {
    Route::get('getAll', [MangsaAirController::class, 'getAll']);
    Route::get('getAllByIdMangsa', [MangsaAirController::class, 'getAllByIdMangsa']);
    Route::get('getMangsaAirForEdit', [MangsaAirController::class, 'getMangsaAirForEdit']);
    Route::post('createOrEdit', [MangsaAirController::class, 'createOrEdit'])->middleware('permission:Halaman.Mangsa.Air.Tambah,Halaman.Mangsa.Air.Edit');
    Route::delete('delete', [MangsaAirController::class, 'delete'])->middleware('permission:Halaman.Mangsa.Air.Hapus');
});

Route::group(['prefix' => 'mangsaWangIhsan', 'middleware' => ['api', 'jwt.verify', 'permission:Halaman.Mangsa.BWI,Halaman.Tabung.BWI']], function () {
    Route::get('getAll', [MangsaWangIhsanController::class, 'getAll']);
    Route::get('getAllByIdMangsa', [MangsaWangIhsanController::class, 'getAllByIdMangsa']);
    Route::get('getAllMangsaByBencanaAndJenisBwi', [MangsaWangIhsanController::class, 'getAllMangsaByBencanaAndJenisBwi']);
    Route::get('getTotalBwiMangsaByIdBencana', [MangsaWangIhsanController::class, 'getTotalBwiMangsaByIdBencana']);
    Route::get('getMangsaWangIhsanForEdit', [MangsaWangIhsanController::class, 'getMangsaWangIhsanForEdit']);
    Route::post('createOrEdit', [MangsaWangIhsanController::class, 'createOrEdit'])->middleware('permission:Halaman.Mangsa.BWI.Tambah,Halaman.Mangsa.BWI.Edit');
    Route::post('multipleCreateMangsaBwi', [MangsaWangIhsanController::class, 'multipleCreateMangsaBwi'])->middleware('permission:Halaman.Mangsa.BWI.Tambah');
    Route::delete('delete', [MangsaWangIhsanController::class, 'delete'])->middleware('permission:Halaman.Mangsa.BWI.Hapus');
});

Route::group(['prefix' => 'mangsaBencana', 'middleware' => ['api', 'jwt.verify', 'permission:Halaman.Mangsa.Bencana']], function () {
    Route::get('getAll', [MangsaBencanaController::class, 'getAll']);
    Route::get('getAllMangsaBencanaLookupTable', [MangsaBencanaController::class, 'getAllMangsaBencanaLookupTable']);
    Route::get('getAllByIdMangsa', [MangsaBencanaController::class, 'getAllByIdMangsa']);
    Route::get('getMangsaBencanaForEdit', [MangsaBencanaController::class, 'getMangsaBencanaForEdit']);
    Route::post('createOrEdit', [MangsaBencanaController::class, 'createOrEdit'])->middleware('permission:Halaman.Mangsa.Bencana.Tambah,Halaman.Mangsa.Bencana.Edit');
    Route::post('multipleCreateMangsaBencana', [MangsaBencanaController::class, 'multipleCreateMangsaBencana'])->middleware('permission:Halaman.Mangsa.Bencana.Tambah');
    Route::delete('delete', [MangsaBencanaController::class, 'delete'])->middleware('permission:Halaman.Mangsa.Bencana.Hapus');
});

Route::group(['prefix' => 'mangsaKerosakan', 'middleware' => ['api', 'jwt.verify']], function () {
    Route::get('getAll', [MangsaKerosakanController::class, 'getAll']);
    Route::get('getAllByIdMangsa', [MangsaKerosakanController::class, 'getAllByIdMangsa']);
    Route::get('getMangsaKerosakanForEdit', [MangsaKerosakanController::class, 'getMangsaKerosakanForEdit']);
    Route::post('createOrEdit', [MangsaKerosakanController::class, 'createOrEdit']);
});

Route::group(['prefix' => 'tabung', 'middleware' => ['api', 'jwt.verify']], function () {
    Route::get('getAll', [TabungController::class, 'getAll']);
    Route::get('getAllTabungForLookupTable', [TabungController::class, 'getAllTabungForLookupTable']);
    Route::get('getTotalTabungCard', [TabungController::class, 'getTotalTabungCard']);
    Route::get('getSejarahTransaksi', [TabungController::class, 'getSejarahTransaksi']);
    Route::get('getTabungByYear', [TabungController::class, 'getTabungByYear']);
    Route::get('getTabungForEdit', [TabungController::class, 'getTabungForEdit']);
    Route::get('getTabungForDropdown', [TabungController::class, 'getTabungForDropdown']);
    Route::get('getTabungByYearForDropdown', [TabungController::class, 'getTabungByYearForDropdown']);
    Route::post('createOrEdit', [TabungController::class, 'createOrEdit'])->middleware('permission:Halaman.Tabung.Tambah,Halaman.Tabung.Edit');
    Route::delete('delete', [TabungController::class, 'delete'])->middleware('permission:Halaman.Tabung.Hapus');
});

Route::group(['prefix' => 'tabungKelulusan', 'middleware' => ['api', 'jwt.verify']], function () {
    Route::get('getAll', [TabungKelulusanController::class, 'getAll']);
    Route::get('getKategoriTabungBayaranTerusByKelulusan', [TabungKelulusanController::class, 'getKategoriTabungBayaranTerusByKelulusan']);
    Route::get('getKategoriTabungSkbByKelulusan', [TabungKelulusanController::class, 'getKategoriTabungSkbByKelulusan']);
    Route::get('getKategoriTabungWaranByKelulusan', [TabungKelulusanController::class, 'getKategoriTabungWaranByKelulusan']);
    Route::get('getKategoriTabungByKelulusan', [TabungKelulusanController::class, 'getKategoriTabungByKelulusan']);
    Route::get('getAllKelulusanForLookupTable', [TabungKelulusanController::class, 'getAllKelulusanForLookupTable']);
    Route::get('getTabungKelulusanForEdit', [TabungKelulusanController::class, 'getTabungKelulusanForEdit']);
    Route::get('getBelanjaByKelulusan', [TabungKelulusanController::class, 'getBelanjaByKelulusan']);
    Route::get('getSkbByIdKelulusan', [TabungKelulusanController::class, 'getSkbByIdKelulusan']);
    Route::get('getWaranByIdKelulusan', [TabungKelulusanController::class, 'getWaranByIdKelulusan']);
    Route::get('getBayaranTerusByIdKelulusan', [TabungKelulusanController::class, 'getBayaranTerusByIdKelulusan']);
    Route::post('createOrEdit', [TabungKelulusanController::class, 'createOrEdit'])->middleware('permission:Halaman.Tabung.Kelulusan.Tambah,Halaman.Tabung.Kelulusan.Edit');
    Route::delete('delete', [TabungKelulusanController::class, 'delete'])->middleware('permission:Halaman.Tabung.Kelulusan.Hapus');
});

Route::group(['prefix' => 'tabungPeruntukan', 'middleware' => ['api', 'jwt.verify']], function () {
    Route::get('getAll', [TabungPeruntukanController::class, 'getAll']);
    Route::get('getPeruntukanByIdTabung', [TabungPeruntukanController::class, 'getPeruntukanByIdTabung']);
    Route::get('getTabungPeruntukanForEdit', [TabungPeruntukanController::class, 'getTabungPeruntukanForEdit']);
    Route::post('createOrEdit', [TabungPeruntukanController::class, 'createOrEdit']);
    Route::delete('delete', [TabungPeruntukanController::class, 'delete']);
});

Route::group(['prefix' => 'tabungBayaranSkb', 'middleware' => ['api', 'jwt.verify', 'permission:Halaman.Tabung.Bayaran.SKB']], function () {
    Route::get('getAll', [TabungBayaranSkbController::class, 'getAll']);
    Route::get('getAllSkbForLookupTable', [TabungBayaranSkbController::class, 'getAllSkbForLookupTable']);
    Route::get('getTabungBayaranSkbForEdit', [TabungBayaranSkbController::class, 'getTabungBayaranSkbForEdit']);
    Route::post('createOrEdit', [TabungBayaranSkbController::class, 'createOrEdit'])->middleware('permission:Halaman.Tabung.Bayaran.SKB.Tambah,Halaman.Tabung.Bayaran.SKB.Edit');
    Route::delete('delete', [TabungBayaranSkbController::class, 'delete'])->middleware('permission:Halaman.Tabung.Bayaran.SKB.Hapus');
});

Route::group(['prefix' => 'tabungBayaranSkbBulanan', 'middleware' => ['api', 'jwt.verify', 'permission:Halaman.Tabung.Bayaran.SKB']], function () {
    Route::get('getAll', [TabungBayaranSkbBulananController::class, 'getAll']);
    Route::get('getAllBulananbyIdSkb', [TabungBayaranSkbBulananController::class, 'getAllBulananbyIdSkb']);
    Route::get('getTabungBayaranSkbBulananForEdit', [TabungBayaranSkbBulananController::class, 'getTabungBayaranSkbBulananForEdit']);
    Route::post('createOrEdit', [TabungBayaranSkbBulananController::class, 'createOrEdit'])->middleware('permission:Halaman.Tabung.Bayaran.SKB.Tambah,Halaman.Tabung.Bayaran.SKB.Edit');
    Route::delete('delete', [TabungBayaranSkbBulananController::class, 'delete'])->middleware('permission:Halaman.Tabung.Bayaran.SKB.Hapus');
});

Route::group(['prefix' => 'tabungBayaranWaran', 'middleware' => ['api', 'jwt.verify', 'permission:Halaman.Tabung.Bayaran.Waran']], function () {
    Route::get('getAll', [TabungBayaranWaranController::class, 'getAll']);
    Route::get('getTabungBayaranWaranForEdit', [TabungBayaranWaranController::class, 'getTabungBayaranWaranForEdit']);
    Route::post('createOrEdit', [TabungBayaranWaranController::class, 'createOrEdit'])->middleware('permission:Halaman.Tabung.Bayaran.Waran.Tambah,Halaman.Tabung.Bayaran.Waran.Edit');
    Route::delete('delete', [TabungBayaranWaranController::class, 'delete'])->middleware('permission:Halaman.Tabung.Bayaran.Waran.Hapus');
});

Route::group(['prefix' => 'tabungBayaranWaranBulanan', 'middleware' => ['api', 'jwt.verify', 'permission:Halaman.Tabung.Bayaran.Waran']], function () {
    Route::get('getAll', [TabungBayaranWaranBulananController::class, 'getAll']);
    Route::get('getAllBulananbyIdWaran', [TabungBayaranWaranBulananController::class, 'getAllBulananbyIdWaran']);
    Route::get('getTabungBayaranWaranBulananForEdit', [TabungBayaranWaranBulananController::class, 'getTabungBayaranWaranBulananForEdit']);
    Route::post('createOrEdit', [TabungBayaranWaranBulananController::class, 'createOrEdit'])->middleware('permission:Halaman.Tabung.Bayaran.Waran.Tambah,Halaman.Tabung.Bayaran.Waran.Edit');
    Route::delete('delete', [TabungBayaranWaranBulananController::class, 'delete'])->middleware('permission:Halaman.Tabung.Bayaran.Waran.Hapus');
});

Route::group(['prefix' => 'tabungBayaranTerus', 'middleware' => ['api', 'jwt.verify', 'permission:Halaman.Tabung.Bayaran.Terus']], function () {
    Route::get('getAll', [TabungBayaranTerusController::class, 'getAll']);
    Route::get('getAllBayaranTerusLookupTable', [TabungBayaranTerusController::class, 'getAllBayaranTerusLookupTable']);
    Route::get('getTabungBayaranTerusForEdit', [TabungBayaranTerusController::class, 'getTabungBayaranTerusForEdit']);
    Route::post('createOrEdit', [TabungBayaranTerusController::class, 'createOrEdit'])->middleware('permission:Halaman.Tabung.Bayaran.Terus.Tambah,Halaman.Tabung.Bayaran.Terus.Edit');
    Route::delete('delete', [TabungBayaranTerusController::class, 'delete'])->middleware('permission:Halaman.Tabung.Bayaran.Terus.Hapus');
});

Route::group(['prefix' => 'tabungBwi', 'middleware' => ['api', 'jwt.verify', 'permission:Halaman.Tabung.BWI']], function () {
    Route::get('getAll', [TabungBwiController::class, 'getAll']);
    Route::get('getAllKir', [TabungBwiController::class, 'getAllKir']);
    Route::get('getTabungBwiForEdit', [TabungBwiController::class, 'getTabungBwiForEdit']);
    Route::post('createOrEdit', [TabungBwiController::class, 'createOrEdit'])->middleware('permission:Halaman.Tabung.BWI.Tambah,Halaman.Tabung.BWI.Edit');
    Route::delete('delete', [TabungBwiController::class, 'delete'])->middleware('permission:Halaman.Tabung.BWI.Hapus');
});

Route::group(['prefix' => 'tabungKelulusanAmbilan', 'middleware' => ['api', 'jwt.verify']], function () {
    Route::get('getAll', [TabungKelulusanAmbilanController::class, 'getAll']);
    Route::get('getTabungKelulusanAmbilanForEdit', [TabungKelulusanAmbilanController::class, 'getTabungKelulusanAmbilanForEdit']);
    Route::post('createOrEdit', [TabungKelulusanAmbilanController::class, 'createOrEdit']);
});

Route::group(['prefix' => 'tabungBwiBayaran', 'middleware' => ['api', 'jwt.verify']], function () {
    Route::get('getAll', [TabungBwiBayaranController::class, 'getAll']);
    Route::get('getAllBwiBayaranTerus', [TabungBwiBayaranController::class, 'getAllBwiBayaranTerus']);
    Route::get('getAllBwiBayaranSkb', [TabungBwiBayaranController::class, 'getAllBwiBayaranSkb']);
    Route::get('getAllBayaranSkbDanTerus', [TabungBwiBayaranController::class, 'getAllBayaranSkbDanTerus']);
    Route::get('getTabungBwiBayaranForEdit', [TabungBwiBayaranController::class, 'getTabungBwiBayaranForEdit']);
    Route::post('createOrEdit', [TabungBwiBayaranController::class, 'createOrEdit']);
    Route::delete('delete', [TabungBwiBayaranController::class, 'delete']);
});

Route::group(['prefix' => 'tabungBwiKawasan', 'middleware' => ['api', 'jwt.verify']], function () {
    Route::get('getAll', [TabungBwiKawasanController::class, 'getAll']);
    Route::get('getAllKawasanByIdBwi', [TabungBwiKawasanController::class, 'getAllKawasanByIdBwi']);
    Route::get('getTabungBwiKawasanForEdit', [TabungBwiKawasanController::class, 'getTabungBwiKawasanForEdit']);
    Route::post('addBwiKawasan', [TabungBwiKawasanController::class, 'addBwiKawasan']);
    Route::post('createOrEdit', [TabungBwiKawasanController::class, 'createOrEdit']);
    Route::delete('delete', [TabungBwiKawasanController::class, 'delete']);
});

Route::group(['prefix' => 'refBencanaNegeri', 'middleware' => ['api', 'jwt.verify']], function () {
    Route::get('getAll', [RefBencanaNegeriController::class, 'getAll']);
    Route::get('getRefBencanaNegeriForEdit', [RefBencanaNegeriController::class, 'getRefBencanaNegeriForEdit']);
    Route::get('getRefBencanaNegeriForDropdown', [RefBencanaNegeriController::class, 'getRefBencanaNegeriForDropdown']);
    Route::get('getRefBencanaNegeriForDropdownByIdBencana', [RefBencanaNegeriController::class, 'getRefBencanaNegeriForDropdownByIdBencana']);
    Route::post('createOrEdit', [RefBencanaNegeriController::class, 'createOrEdit']);
});

Route::group(['prefix' => 'refJenisBwi', 'middleware' => ['api', 'jwt.verify']], function () {
    Route::get('getAll', [RefJenisBwiController::class, 'getAll']);
    Route::get('getRefJenisBwiForEdit', [RefJenisBwiController::class, 'getRefJenisBwiForEdit']);
    Route::get('getRefJenisBwiForDropdown', [RefJenisBwiController::class, 'getRefJenisBwiForDropdown']);
    Route::post('createOrEdit', [RefJenisBwiController::class, 'createOrEdit'])->middleware(['api', 'jwt.verify','permission:Halaman.Tetapan.JenisBwi']);
});

Route::group(['prefix' => 'refJenisBayaran', 'middleware' => ['api', 'jwt.verify']], function () {
    Route::get('getAll', [RefJenisBayaranController::class, 'getAll']);
    Route::get('getRefJenisBayaranForEdit', [RefJenisBayaranController::class, 'getRefJenisBayaranForEdit']);
    Route::get('getRefJenisBayaranForDropdown', [RefJenisBayaranController::class, 'getRefJenisBayaranForDropdown']);
    Route::post('createOrEdit', [RefJenisBayaranController::class, 'createOrEdit'])->middleware(['api', 'jwt.verify','permission:Halaman.Tetapan.JenisBayaran']);
});

Route::group(['prefix' => 'refKategoriBayaran', 'middleware' => ['api', 'jwt.verify']], function () {
    Route::get('getAll', [RefKategoriBayaranController::class, 'getAll']);
    Route::get('getRefKategoriBayaranForEdit', [RefKategoriBayaranController::class, 'getRefKategoriBayaranForEdit']);
    Route::get('getRefKategoriBayaranForDropdown', [RefKategoriBayaranController::class, 'getRefKategoriBayaranForDropdown']);
    Route::post('createOrEdit', [RefKategoriBayaranController::class, 'createOrEdit']);
});

Route::group(['prefix' => 'refJenisPeruntukan', 'middleware' => ['api', 'jwt.verify']], function () {
    Route::get('getAll', [RefJenisPeruntukanController::class, 'getAll']);
    Route::get('getRefJenisPeruntukanForEdit', [RefJenisPeruntukanController::class, 'getRefJenisPeruntukanForEdit']);
    Route::get('getRefJenisPeruntukanForDropdown', [RefJenisPeruntukanController::class, 'getRefJenisPeruntukanForDropdown']);
    Route::post('createOrEdit', [RefJenisPeruntukanController::class, 'createOrEdit']);
});

// 
// Route::get('jumlah-kematian-covid19', [DashboardController::class, 'getJumlahKematianCovid19']);

