<?php

namespace App\Http\Controllers;

use App\Http\AppConst;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SessionController extends Controller
{
    public function getProfil(){
        $user = JWTAuth::user();

        $peranan = DB::table('ref_peranan')
        ->select('peranan')
        ->where('ref_peranan.id', '=', $user->id_peranan)
        ->first();

        $daerah = DB::table('ref_daerah')
        ->select('nama_daerah')
        ->where('ref_daerah.id', '=', $user->id_daerah)
        ->first();

        $negeri = DB::table('ref_negeri')
        ->select('nama_negeri')
        ->where('ref_negeri.id', '=', $user->id_negeri)
        ->first();

        $kementerian = DB::table('ref_kementerian')
        ->select('nama_kementerian')
        ->where('ref_kementerian.id','=', $user->id_kementerian)
        ->first();

        $agensi = DB::table('ref_agensi')
        ->select('nama_agensi')
        ->where('ref_agensi.id','=', $user->id_agensi)
        ->first();

        $capaian = $user->getPermissions()->pluck('nama');

        return response()->json([
            'pengguna'=> $user->only(['id', 'nama', 'emel', 'no_kp', 'id_kementerian', 'id_agensi', 'jawatan', 'alamat_1', 'alamat_2', 'telefon_pejabat','telefon_bimbit','id_negeri','id_daerah',
            'fax','status_pengguna','id_peranan','poskod', 'gambar']),
            'peranan' => $peranan,
            'daerah' => $daerah,
            'negeri' => $negeri,
            'kementerian' => $kementerian->nama_kementerian,
            'agensi' => $agensi->nama_agensi,
            'capaian' => $capaian
        ], 200);
    }

    public function updateProfil(Request $request){
        $validator = Validator::make($request->all(), [
            'pengguna.nama' => 'required|max:80',
            'pengguna.id_kementerian' => 'required|numeric',
            'pengguna.id_agensi' => 'required|numeric',
            'pengguna.no_kp' => 'max:12',
            'pengguna.jawatan' => 'required|max:255',
            'pengguna.telefon_pejabat' => 'required|max:15',
            'pengguna.telefon_bimbit' => 'required|max:15',
            'pengguna.emel' => 'required|email|max:80'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $pengguna = $request->pengguna;

        $user = JWTAuth::user();
        if($user->no_kp != $pengguna['no_kp']){
            $checkNoKp = User::where('no_kp', 'ILIKE', '%' . $pengguna['no_kp'] . '%')->first();
            if($checkNoKp){
                return response()->json([
                    'message' => 'No. Kad Pengenalan Sudah Didaftarkan. Sila Masukkan No. Kad Pengenalan Lain'
                ], 200);
            }
        }

        $user->nama = $pengguna['nama'];
        $user->id_kementerian = $pengguna['id_kementerian'];
        $user->id_agensi = $pengguna['id_agensi'];
        $user->jawatan = $pengguna['jawatan'];
        $user->alamat_1 = $pengguna['alamat_1'] ?? null;
        $user->alamat_2 = $pengguna['alamat_2'] ?? null;
        $user->fax = $pengguna['fax'] ?? null;
        $user->emel = $pengguna['emel'];
        $user->no_kp = $pengguna['no_kp'];
        $user->telefon_pejabat = $pengguna['telefon_pejabat'];
        $user->telefon_bimbit = $pengguna['telefon_bimbit'];
        $user->poskod = $pengguna['poskod'] ?? null;
        $user->id_negeri = $pengguna['id_negeri'] ?? null;
        $user->id_daerah = $pengguna['id_daerah'] ?? null;
        $user->save();

        return response()->json([
            'message' => 'Maklumat profil telah dikemaskini.'
        ], 200);
    }

    public function changePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'kata_laluan_lama' => 'required',
            'kata_laluan_baru' => 'required|min:6',
            'ulang_kata_laluan_baru' => 'required|same:kata_laluan_baru',
        ]);

        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 422);
        }

        $pengguna = JWTAuth::user();

        $credentials = array('emel' => $pengguna->emel, 'password' => $request->kata_laluan_lama);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['message' => 'Kata laluan lama tidak sepadan.'], 200);
        }

        $pengguna->kata_laluan = bcrypt($request->kata_laluan_baru);
        $pengguna->save();

        return response()->json(['message' => 'Kata laluan berjaya ditukar'], 200);
    }

    public function uploadGambarProfil(Request $request){
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|max:5120',
        ]);

        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 422);
        }

        $ext = $request->file('image')->extension();
        $fileName = Str::uuid().'.'.$ext;

        Storage::putFileAs(AppConst::ProfileStorage, $request->file('image'), $fileName);

        $filePath = config('app.url').Storage::url(AppConst::ProfileStorage.$fileName);

        $pengguna = JWTAuth::user();
        $pengguna->gambar = $filePath;
        $pengguna->save();

        return response()->json(['gambar'=> $filePath], 200);
    }

}
