<?php

namespace App\Http\Controllers;

use App\Http\Excels\Laporan\SenaraiPenggunaExcel;
use App\Models\Capaian;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    public function getAllUser(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterAgensi = $request->filterAgensi;
        $filterPeranan = $request->filterPeranan;
        $filterStatus = $request->filterStatus;
        $filterFromDate =  $request->filterFromDate ?? null;
        $filterToDate = $request->filterToDate ?? null;

        $columns = [
            'tbl_pengguna.id', 'nama', 'tbl_pengguna.id_kementerian', 'id_agensi', 'jawatan', 'id_peranan', 'status_pengguna',
            'nama_agensi', 'nama_kementerian', 'peranan', 'no_kp', 'emel', 'tarikh_daftar'
        ];

        $data = DB::table('tbl_pengguna')
            ->join('ref_agensi', 'tbl_pengguna.id_agensi', 'ref_agensi.id')
            ->join('ref_kementerian', 'tbl_pengguna.id_kementerian', 'ref_kementerian.id')
            ->join('ref_peranan', 'tbl_pengguna.id_peranan', 'ref_peranan.id')
            ->select($columns)
            ->where('status_pengguna', '!=', 1)
            ->where('hapus', false)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function($query) use ($filterAgensi){
                $query->when($filterAgensi, function($query, $filterAgensi){
                    return $query->where('tbl_pengguna.id_agensi', $filterAgensi);
                });
            })
            ->where(function($query) use ($filterPeranan){
                $query->when($filterPeranan, function($query, $filterPeranan){
                    return $query->where('tbl_pengguna.id_peranan', $filterPeranan);
                });
            })
            ->where(function($query) use ($filterStatus){
                $query->when($filterStatus, function($query, $filterStatus){
                   return $query->where('status_pengguna', $filterStatus);
                });
            })
            ->where(function($query) use ($filterFromDate){
                $query->when($filterFromDate, function($query, $filterFromDate){
                    return $query->whereDate('tarikh_daftar', '>=', Carbon::parse($filterFromDate)->startOfDay());
                });
            })
            ->where(function($query) use ($filterToDate){
                $query->when($filterToDate, function($query, $filterToDate){
                    return $query->whereDate('tarikh_daftar', '<=', Carbon::parse($filterToDate)->endOfDay());
                });
            })
            ->select($columns);

        $totalCount = $data->count();

        $result = $data
            ->when($sorting, function ($query, $sorting) {
                $sort = explode(" ", $sorting);
                return $query->orderBy($sort[0], $sort[1]);
            })->when($skipCount, function ($query, $skipCount) {
                return $query->skip($skipCount);
            })
            ->take($maxResultCount)
            ->get();

        return response()->json([
            'total_count'=>$totalCount,
            'items'=> $result
        ], 200);
    }

    public function exportAllUserToExcel(Request $request)
    {
        $input = $request->all();
        $file['file_name'] = 'Senarai_Pengguna' . Carbon::now()->format('Ymd-hi') . '.xlsx';
        $file['file_token'] = uniqid();
        $file['file_type'] = 'xlsx';
        Excel::store(new SenaraiPenggunaExcel($input), $file['file_token'] . '.' . $file['file_type'], 'temp');
        return response()->json($file, 200);
    }

    public function senaraiUserExcelQuery($input)
    {
        $filter = array_key_exists('filter', $input) ? $input['filter']  : null;
        $filterAgensi = array_key_exists('filterAgensi', $input) ? $input['filterAgensi']  : null;
        $filterPeranan = array_key_exists('filterPeranan', $input) ? $input['filterPeranan']  : null;
        $filterFromDate = array_key_exists('filterFromDate', $input) ? $input['filterFromDate']  : null;
        $filterToDate = array_key_exists('filterToDate', $input) ? $input['filterToDate']  : null;
        $filterStatus = array_key_exists('filterStatus', $input) ? $input['filterStatus']  : null;

        $columns = [
            'nama', 'emel', 'nama_agensi', 'peranan', 'tarikh_daftar', 'status_pengguna', 'tbl_pengguna.id'
        ];

        $user = DB::table('tbl_pengguna')
            ->join('ref_agensi', 'tbl_pengguna.id_agensi', 'ref_agensi.id')
            ->join('ref_kementerian', 'tbl_pengguna.id_kementerian', 'ref_kementerian.id')
            ->join('ref_peranan', 'tbl_pengguna.id_peranan', 'ref_peranan.id')
            ->select($columns)
            ->where('status_pengguna', '!=', 1)
            ->where('hapus', false)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function($query) use ($filterAgensi){
                $query->when($filterAgensi, function($query, $filterAgensi){
                    return $query->where('tbl_pengguna.id_agensi', $filterAgensi);
                });
            })
            ->where(function($query) use ($filterPeranan){
                $query->when($filterPeranan, function($query, $filterPeranan){
                    return $query->where('tbl_pengguna.id_peranan', $filterPeranan);
                });
            })
            ->where(function($query) use ($filterStatus){
                $query->when($filterStatus, function($query, $filterStatus){
                return $query->where('status_pengguna', $filterStatus);
                });
            })
            ->where(function($query) use ($filterFromDate){
                $query->when($filterFromDate, function($query, $filterFromDate){
                    return $query->whereDate('tarikh_daftar', '>=', Carbon::parse($filterFromDate)->startOfDay());
                });
            })
            ->where(function($query) use ($filterToDate){
                $query->when($filterToDate, function($query, $filterToDate){
                    return $query->whereDate('tarikh_daftar', '<=', Carbon::parse($filterToDate)->endOfDay());
                });
            })
            ->select($columns);

            $userList = $user
            ->orderBy('tbl_pengguna.id')
            ->get();

            $data = array();
            foreach($userList as $i){
                if($i->status_pengguna == 1){
                    $i->status_pengguna = "Permohonan";
                }else if($i->status_pengguna == 2){
                    $i->status_pengguna = "Berdaftar";
                }else if($i->status_pengguna == 3){
                    $i->status_pengguna = "Tidak Aktif";
                }else if($i->status_pengguna == 4){
                    $i->status_pengguna = "Ditolak";
                }
                unset($i->id);
                array_push($data, $i);
            }
            return collect($data);
    }

    public function getAllPermohonanUser(Request $request){
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterAgensi = $request->filterAgensi;
        $filterPeranan = $request->filterPeranan;
        $filterFromDate =  $request->filterFromDate ?? null;
        $filterToDate = $request->filterToDate ?? null;

        $columns = [
            'tbl_pengguna.id', 'nama', 'tbl_pengguna.id_kementerian', 'id_agensi', 'jawatan', 'id_peranan', 'status_pengguna',
            'nama_agensi', 'nama_kementerian', 'peranan', 'no_kp', 'emel', 'tarikh_daftar'
        ];

        $data = DB::table('tbl_pengguna')
            ->join('ref_agensi', 'tbl_pengguna.id_agensi', 'ref_agensi.id')
            ->join('ref_kementerian', 'tbl_pengguna.id_kementerian', 'ref_kementerian.id')
            ->join('ref_peranan', 'tbl_pengguna.id_peranan', 'ref_peranan.id')
            ->select($columns)
            ->where('hapus', false)
            ->where('status_pengguna', '=', 1)
            ->where(function ($query) use ($filter, $columns){
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach($columns as $column){
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function($query) use ($filterAgensi){
                $query->when($filterAgensi, function($query, $filterAgensi){
                    return $query->where('tbl_pengguna.id_agensi', $filterAgensi);
                });
            })
            ->where(function($query) use ($filterPeranan){
                $query->when($filterPeranan, function($query, $filterPeranan){
                    return $query->where('tbl_pengguna.id_peranan', $filterPeranan);
                });
            })
            ->where(function($query) use ($filterFromDate){
                $query->when($filterFromDate, function($query, $filterFromDate){
                    return $query->whereDate('tarikh_daftar', '>=', Carbon::parse($filterFromDate)->startOfDay());
                });
            })
            ->where(function($query) use ($filterToDate){
                $query->when($filterToDate, function($query, $filterToDate){
                    return $query->whereDate('tarikh_daftar', '<=', Carbon::parse($filterToDate)->endOfDay());
                });
            })
            ->select($columns);

        $totalCount = $data->count();

        $result = $data
            ->when($sorting, function ($query, $sorting) {
                $sort = explode(" ", $sorting);
                return $query->orderBy($sort[0], $sort[1]);
            })->when($skipCount, function ($query, $skipCount) {
                return $query->skip($skipCount);
            })
            ->take($maxResultCount)
            ->get();

        return response()->json([
            'total_count'=>$totalCount,
            'items'=> $result
        ], 200);
    }

    public function ApprovedUser(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $officerId = JWTAuth::user()->id;
        $generate = new GenerateController;
        $password = $generate->getRandomPassword();

        try {
            DB::beginTransaction();
            $userStatus = User::find($request->id);
            $userStatus->status_pengguna = 2;
            $userStatus->id_pengguna_lulus = $officerId;
            $userStatus->tukar_kata_laluan = true;
            $userStatus->kata_laluan = bcrypt($password);

            $userStatus->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace()[0]['args'], 500);
        }

        $mail_controller = new MailController;
        $mail_controller->approveUser($userStatus->nama, $userStatus->emel, $password);

        return response()->json(['message'=> 'Pengguna berjaya diluluskan!'], 200);
    }

    public function getUserForEdit(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $pengguna = DB::table('tbl_pengguna')
            ->join('ref_agensi', 'tbl_pengguna.id_agensi', 'ref_agensi.id')
            ->join('ref_kementerian', 'tbl_pengguna.id_kementerian', 'ref_kementerian.id')
            ->join('ref_peranan', 'tbl_pengguna.id_peranan', 'ref_peranan.id')
            ->leftJoin('ref_daerah', 'tbl_pengguna.id_daerah', 'ref_daerah.id')
            ->leftJoin('ref_negeri', 'tbl_pengguna.id_negeri', 'ref_negeri.id')
            ->where('tbl_pengguna.id', '=', $request->id)
            ->where('hapus', false)
            ->select('tbl_pengguna.id', 'nama', 'tbl_pengguna.id_kementerian', 'id_agensi', 'no_kp', 'jawatan', 'alamat_1', 'alamat_2',
             'telefon_pejabat', 'telefon_bimbit', 'fax', 'emel', 'status_pengguna', 'id_peranan', 'nama_agensi', 'nama_kementerian', 'peranan',
             'poskod', 'tbl_pengguna.id_daerah', 'tbl_pengguna.id_negeri', 'nama_daerah', 'nama_negeri', 'catatan' )
            ->first();

        $permissions = $this->getCapaian($pengguna);

        return response()->json([
            'pengguna'=> $pengguna,
            'capaian_dibenarkan' => $permissions
        ], 200);
    }

    public function createOrEdit(Request $request){
        $pengguna  = $request->pengguna;

        if($pengguna['id'] ?? false){
            $pengguna = $this->edit($request);
        }else{
            $pengguna = $this->create($request);
        }

        return $pengguna;
    }


    public function create($request){
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

        $generate = new GenerateController;
        $password = $generate->getRandomPassword();
        $inputUser = $request->pengguna;

        try {
            DB::beginTransaction();
            $checkUserEmail = User::where('emel', 'ILIKE', '%' . $inputUser['emel'] . '%')->where('hapus', false)->first();
            $checkNoKp = User::where('no_kp', 'ILIKE', '%' . $inputUser['no_kp'] . '%')->where('hapus', false)->first();
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
                    'nama' => $inputUser['nama'],
                    'id_kementerian' => $inputUser['id_kementerian'],
                    'id_agensi' => $inputUser['id_agensi'],
                    'no_kp' => $inputUser['no_kp'],
                    'jawatan' => $inputUser['jawatan'],
                    'alamat_1' => $inputUser['alamat_1'] ?? null,
                    'alamat_2' => $inputUser['alamat_2'] ?? null,
                    'telefon_pejabat' => $inputUser['telefon_pejabat'],
                    'telefon_bimbit' => $inputUser['telefon_bimbit'],
                    'fax' => $inputUser['fax'] ?? null,
                    'emel' => $inputUser['emel'],
                    'kata_laluan' => bcrypt($password),
                    'status_pengguna' => 2,
                    'id_peranan' => $inputUser['id_peranan'],
                    'tarikh_daftar' => Carbon::now(),
                    'poskod' => $inputUser['poskod'] ?? null,
                    'id_daerah' => $inputUser['id_daerah'] ?? null,
                    'id_negeri' => $inputUser['id_negeri'] ?? null,
                    'tukar_kata_laluan' => true,
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
        $mail_controller->createUser($inputUser['nama'], $inputUser['emel'], $password);

        return response()->json(['message'=> 'Pendaftaran Pengguna Berjaya!'], 200);
    }

    public function edit($request){
        $validator = Validator::make($request->all(), [
            'pengguna.id' => 'required',
            'pengguna.nama' => 'required|max:80',
            'pengguna.id_kementerian' => 'required|numeric',
            'pengguna.id_agensi' => 'required|numeric',
            'pengguna.no_kp' => 'required|max:12',
            'pengguna.jawatan' => 'required|max:80',
            'pengguna.telefon_pejabat' => 'required|max:15',
            'pengguna.telefon_bimbit' => 'required|max:15',
            'pengguna.emel' => 'required|email|max:80',
            'pengguna.status_pengguna' => 'required|numeric'
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $user = JWTAuth::user();
        $inputUser = $request->pengguna;
        $pengguna = User::where('id', $inputUser['id'])->first();
        $generate = new GenerateController;
        $password = $generate->getRandomPassword();

        try {
            DB::beginTransaction();
            if($pengguna->no_kp != $inputUser['no_kp']){
                $checkNoKp = User::where('no_kp', 'ILIKE', '%' . $inputUser['no_kp'] . '%')->where('hapus', false)->first();
                if($checkNoKp){
                    return response()->json([
                        'message' => 'No. Kad Pengenalan Sudah Didaftarkan. Sila Masukkan No. Kad Pengenalan Lain'
                    ], 200);
                }
            }

            $pengguna->nama = $inputUser['nama'];
            $pengguna->id_kementerian = $inputUser['id_kementerian'];
            $pengguna->id_agensi = $inputUser['id_agensi'];
            $pengguna->no_kp = $inputUser['no_kp'];
            $pengguna->jawatan = $inputUser['jawatan'];
            $pengguna->alamat_1 = $inputUser['alamat_1'] ?? null;
            $pengguna->alamat_2 = $inputUser['alamat_2'] ?? null;
            $pengguna->telefon_pejabat = $inputUser['telefon_pejabat'];
            $pengguna->telefon_bimbit = $inputUser['telefon_bimbit'];
            $pengguna->fax = $inputUser['fax'] ?? null;
            $pengguna->emel = $inputUser['emel'];
            $pengguna->id_pengguna_kemaskini = $user->id;
            $pengguna->tarikh_kemaskini = Carbon::now();
            $pengguna->poskod = $inputUser['poskod'] ?? null;
            $pengguna->id_daerah = $inputUser['id_daerah'] ?? null;
            $pengguna->id_negeri = $inputUser['id_negeri'] ?? null;
            $pengguna->save();

            $mail_controller = new MailController;

            if(($pengguna->status_pengguna == 1 || $pengguna->status_pengguna == 4) && $inputUser['status_pengguna'] == 2){
                $pengguna->kata_laluan = bcrypt($password);
                $pengguna->tukar_kata_laluan = true;
                $mail_controller->approveUser($pengguna->nama, $pengguna->emel, $password);

            }else if($pengguna->status_pengguna == 1 && $inputUser['status_pengguna'] == 4){
                $mail_controller->tolakUser($pengguna->nama, $pengguna->emel, $inputUser['catatan']);

            }else if($pengguna->status_pengguna == 2 && $inputUser['status_pengguna'] == 3){
                $mail_controller->deactivatedUser($pengguna->nama, $pengguna->emel, $inputUser['catatan']);

            }else if($pengguna->status_pengguna == 3 && $inputUser['status_pengguna'] == 2){
                $mail_controller->changeToBerdaftar($pengguna->nama, $pengguna->emel);
            }

            $pengguna->status_pengguna = $inputUser['status_pengguna'];
            $pengguna->catatan = $inputUser['catatan'] ?? null;
            $pengguna->save();

            $this->updateCapaianPengguna($pengguna, $request->capaian_dibenarkan);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage(), 'stack' => $e->getTrace() ], 500);
        }

        return response()->json(['message' => 'Data telah dikemaskini'], 200);
    }

    public function changeEmelAndPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $user = JWTAuth::user();
        $generate = new GenerateController;
        $password = $generate->getRandomPassword();

        try {
            DB::beginTransaction();
            $pengguna = User::find($request->id);

            if($request->changeEmel){
                $checkUserEmail = User::where('emel', 'ILIKE', '%' . $request->changeEmel . '%')->where('hapus', false)->first();
                if($checkUserEmail){
                    return response()->json([
                        'message' => 'Emel Sudah Didaftarkan. Sila Guna Emel Lain'
                    ], 200);
                }else{
                    $mail_controller = new MailController;
                    $mail_controller->tukarEmelLama($pengguna->nama, $pengguna->emel, $request->changeEmel, $user->nama);

                    if($request->changePassword){
                        $pengguna->kata_laluan = bcrypt($request->changePassword);
                        $mail_controller->tukarEmelBaru($pengguna->nama, $pengguna->emel, $request->changeEmel, $request->changePassword, $user->nama);
                    }else{
                        $pengguna->kata_laluan = bcrypt($password);
                        $mail_controller->tukarEmelBaru($pengguna->nama, $pengguna->emel, $request->changeEmel, $password, $user->nama);
                    }

                    $pengguna->emel = $request->changeEmel;
                    $pengguna->tukar_kata_laluan = true;
                    $pengguna->save();
                }
            } else if($request->changePassword && $request->changeEmel == null){
                $pengguna->kata_laluan = bcrypt($request->changePassword);
                $pengguna->tukar_kata_laluan = true;
                $pengguna->save();

                $mail_controller = new MailController;
                $mail_controller->tukarPassword($pengguna->nama, $pengguna->emel, $request->changePassword, $user->nama);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace()[0]['args'], 500);
        }

        return response()->json(['message'=> 'Emel atau Kata Laluan Berjaya Ditukar'], 200);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        try {
            DB::beginTransaction();

            $pengguna = User::where('id', $request->id)->first();

            if($pengguna->login_terakhir == null){
                $pengguna->hapus = true;
                $pengguna->save();
            }else{
                return response()->json(["message" => "Pengguna ($pengguna->nama) Sedang Menggunakan Sistem. Anda Hanya Boleh Menukar Status Pengguna Sahaja"], 200);
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace(), 500);
        }

        return response()->json(["message" => "Pengguna Berjaya Dibuang"], 200);
    }

    private function getCapaian($user){
        $user_permissions = Capaian::where('id_pengguna', $user->id)
            ->where('pembeza', 'CapaianPengguna')
            ->get();

        $allowed = $user_permissions->where('dibenarkan', true);
        $forbidden = $user_permissions->where('dibenarkan', false)->pluck('nama');

        $role_permissions = Capaian::where('id_peranan', $user->id_peranan)
            ->where('pembeza', 'CapaianPeranan')
            ->whereNotIn('nama', $forbidden)
            ->where('dibenarkan', true)
            ->orderBy('nama')
            ->get();

        $combined = $allowed->merge($role_permissions);
        return $combined->pluck('nama');
    }

    private function updateCapaianPengguna($user, $capaian_dibenarkan = []){
        $permissions = $capaian_dibenarkan;

        $user_permissions = Capaian::where('id_pengguna', $user->id)
            ->where('pembeza', 'CapaianPengguna')
            ->get();

        $allowed = $user_permissions->where('dibenarkan', true);
        $forbidden = $user_permissions->where('dibenarkan', false)->pluck('nama');

        $role_permissions = Capaian::where('id_peranan', $user->id_peranan)
            ->where('pembeza', 'CapaianPeranan')
            ->where('dibenarkan', true)
            ->whereNotIn('nama', $forbidden)
            ->get();

        $granted_ids = $allowed->merge($role_permissions)->pluck('id');

        $granted_permissions = DB::table('tbl_capaian')->whereIn('id', $granted_ids)->get()->pluck('nama')->toArray();


        $grantPermissions = array_diff($permissions, $granted_permissions);
        foreach($grantPermissions as $grant){
            $capaian = Capaian::where('nama', $grant)->where('id_pengguna', $user->id)->where('dibenarkan', false)->first();
            if(!$capaian){
                Capaian::create([
                    'nama' => $grant,
                    'pembeza' => 'CapaianPengguna',
                    'id_pengguna' => $user->id,
                    'dibenarkan' => true,
                    'tarikh_cipta' => Carbon::now()
                ]);
            }else{
                $capaian->dibenarkan = true;
                $capaian->tarikh_kemaskini = Carbon::now();
                $capaian->save();
            }
        }

        $revokePermissions = array_diff($granted_permissions, $permissions);
        foreach($revokePermissions as $revoke){
            $capaian = Capaian::where('nama', $revoke)->where('id_pengguna', $user->id)->where('dibenarkan', true)->first();
            if(!$capaian){
                Capaian::create([
                    'nama' => $revoke,
                    'pembeza' => 'CapaianPengguna',
                    'id_pengguna' => $user->id,
                    'dibenarkan' => false,
                    'tarikh_cipta' => Carbon::now()
                ]);
            }else{
                $capaian->dibenarkan = false;
                $capaian->tarikh_kemaskini = Carbon::now();
                $capaian->save();
            }
        }
        return response()->json(['message'=> 'Success'], 200);
    }

}
