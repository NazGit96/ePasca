<?php

namespace App\Http\Controllers;

use App\Models\RefAgensi;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|between:2,100',
            'emel' => 'required|string|email|max:100|unique:users',
            'kata_laluan' => 'required|string|confirmed|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 422);
        }

        $user = User::create(array_merge(
            $validator->validated(),
            ['kata_laluan' => bcrypt($request->kata_laluan)]
        ));

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ], 201);
    }


    /**
     * Get a JWT token via given credentials.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'emel' => 'required|email',
            'kata_laluan' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $status = DB::table('tbl_pengguna')
        ->where('tbl_pengguna.emel', $request->emel)
        ->where('hapus', false)
        ->select('status_pengguna')
        ->first();

        if (!$status) {
            return response()->json(['message' => 'Emel atau Kata Laluan salah. Sila cuba lagi.'], 200);
        }

        switch ($status->status_pengguna) {
            case 1:
                return response()->json(['message' => 'Pengguna masih dalam proses pengesahan.  Sila cuba lagi selepas anda mendapat emel pengesahan.'], 200);
                break;
            case 3:
                return response()->json(['message' => 'Pengguna tidak aktif. Hanya pengguna yang aktif sahaja dibenarkan untuk akses sistem ini.'], 200);
                break;
            case 4:
                return response()->json(['message' => 'Pengguna tidak sah kerana permohonan telah ditolak. Harap maklum.'], 200);# code...
                break;
            default:
                break;
        }

        $credentials = array('emel' => $request->emel, 'password' => $request->kata_laluan, 'status_pengguna'=> 2);

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['message' => 'Emel atau Kata Laluan salah. Sila cuba lagi.'], 200);
        }

        return $this->respondWithToken($token, JWTAuth::user()->tukar_kata_laluan);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {
        $user = $request->user();
        return $user->getPermissions();
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        JWTAuth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(JWTAuth::refresh(),false);
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $tukar_kata_laluan)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'tukar_kata_laluan' => $tukar_kata_laluan,
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }

    public function registerUser(Request $request){
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:80',
            'id_kementerian' => 'required|numeric',
            'id_agensi' => 'required|numeric',
            'no_kp' => 'max:12',
            'jawatan' => 'required|max:255',
            'alamat1' => 'required|max:255',
            'telefon_pejabat' => 'required|max:15',
            'telefon_bimbit' => 'required|max:15',
            'emel' => 'required|email|max:80',
            'poskod' => 'required|max:5',
            'id_daerah' => 'required|numeric',
            'id_negeri' => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();
            $checkUserEmail = User::where('emel', 'ILIKE', '%' . $request->emel . '%')->where('hapus', false)->first();
            $checkNoKp = User::where('no_kp', 'ILIKE', '%' . $request->no_kp . '%')->where('hapus', false)->first();
            if($checkUserEmail){
                return response()->json([
                    'message' => 'Emel Sudah Didaftarkan. Sila Guna Emel Lain'
                ], 200);
            }
            else if($checkNoKp){
                return response()->json([
                    'message' => 'No. Kad Pengenalan Sudah Didaftarkan. Sila Masukkan No. Kad Pengenalan Lain'
                ], 200);
            }
            else{
                $user = User::create([
                    'nama' => $request->nama,
                    'id_kementerian' => $request->id_kementerian,
                    'id_agensi' => $request->id_agensi,
                    'no_kp' => $request->no_kp,
                    'jawatan' => $request->jawatan,
                    'alamat_1' => $request->alamat1,
                    'alamat_2' => $request->alamat2 ?? null,
                    'telefon_pejabat' => $request->telefon_pejabat,
                    'telefon_bimbit' => $request->telefon_bimbit,
                    'fax' => $request->fax ?? null,
                    'emel' => $request->emel,
                    'status_pengguna' => 1,
                    'id_peranan' => 2,
                    'tarikh_daftar' => Carbon::now(),
                    'poskod' => $request->poskod,
                    'id_daerah' => $request->id_daerah,
                    'id_negeri' => $request->id_negeri,
                    'hapus' => false
                ]);
                $user->save();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace(), 500);
        }

        $mail_controller = new MailController;
        $mail_controller->registerUser($request->nama, $request->emel);

        $user = DB::Table('tbl_pengguna')
            ->where('id_peranan', 1)
            ->get();

        $agensi = RefAgensi::where('id', $request->id_agensi)->first();

        foreach($user as $u){
            $mail_controller = new MailController;
            $mail_controller->registerAgensiAdmin($u->nama, $u->emel, $request->nama, $request->jawatan, $agensi->nama_agensi);
        }

        return response()->json(['message'=> 'Pendaftaran Pengguna Berjaya!'], 200);
    }

    public function forgotPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'emel' => 'required|string|email',
        ]);

        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 422);
        }

        $pengguna = User::where('emel', $request->emel)
            ->where('status_pengguna', 2)
            ->first();

        if(!$pengguna){
            return response()->json([
                'message'=> "Tiada pengguna untuk emel $request->emel dijumpai. Sila semak semula emel."
            ], 422);
        }

        $random = bin2hex(random_bytes(12));
        $kod_akses = strtoupper($random);
        $pengguna->kod_akses = $kod_akses;
        $pengguna->tarikh_kod_akses = Carbon::now();
        $pengguna->save();

        $reset_url = config('app.client_url')."/akaun/reset?emel=$pengguna->emel&kod_akses=$kod_akses";

        $mail_controller = new MailController;
        $mail_controller->forgotPassword($pengguna->nama, $pengguna->emel, $reset_url);

        return response()->json(['message' => "Kami telah menghantar pautan tetapan semula kata laluan anda melalui emel."], 200);
    }

    public function verifyCode(Request $request){
        $validator = Validator::make($request->all(), [
            'emel' => 'required|string|email',
            'kod_akses' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 422);
        }

        $pengguna = User::where('emel', $request->emel)
            ->where('kod_akses', $request->kod_akses)
            ->where('status_pengguna', 2)
            ->first();

        if(!$pengguna){
            return response()->json(['message' => "Kod akses yang dimasukkan adalah tidak sah"], 422);
        }

        if(Carbon::parse($pengguna->tarikh_kod_akses)->addMinutes(60)->isPast()){
            return response()->json(['message' => "Kod akses yang dimasukkan telah tamat tempoh. Sila minta kod akses yang baru."], 422);
        }

        return response()->json(['message' => "Kod akses yang dimasukkan adalah sah"], 200);
    }

    public function resetPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'kata_laluan' => 'required|string|min:6',
            'ulang_kata_laluan' => 'required|same:kata_laluan',
            'emel' => 'required|string|email',
            'kod_akses' => 'required|string',
        ]);

        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 422);
        }

        $pengguna = User::where('emel', $request->emel)
            ->where('kod_akses', $request->kod_akses)
            ->where('status_pengguna', 2)
            ->first();

        if(!$pengguna){
            return response()->json(['message' => "Kod akses yang dimasukkan adalah tidak sah"], 200);
        }

        $pengguna->kata_laluan = bcrypt($request->kata_laluan);
        $pengguna->kod_akses = null;
        $pengguna->tarikh_kod_akses = null;
        $pengguna->save();

        $mail_controller = new MailController;
        $mail_controller->passwordChanged($pengguna->nama, $pengguna->emel);

        return response()->json(['message' => "Kata laluan telah ditetapkan semula. Sila log masuk dengan kata laluan baru anda."], 200);

    }

    public function changePassword(Request $request){
        $validator = Validator::make($request->all(), [
            'kata_laluan_baru' => 'required|min:6',
            'ulang_kata_laluan_baru' => 'required|same:kata_laluan_baru',
        ]);

        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 422);
        }

        $pengguna = JWTAuth::user();
        $pengguna->kata_laluan = bcrypt($request->kata_laluan_baru);
        $pengguna->tukar_kata_laluan = false;
        $pengguna->login_terakhir = Carbon::now();
        $pengguna->save();

        return response()->json(['message' => 'Kata laluan berjaya ditukar'], 200);
    }
}
