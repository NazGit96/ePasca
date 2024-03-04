<?php

namespace App\Http\Controllers;

use App\Models\Mangsa;
use App\Models\MangsaBencana;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\AppConst;
use App\Imports\MangsaImport;
use App\Models\MangsaAir;
use Maatwebsite\Excel\Facades\Excel;

class MangsaController extends Controller
{
    public function getAll(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;
        $filterNegeri = $request->filterNegeri;
        $filterAgensi = $request->filterAgensi;
        $filterIdBencana = $request->filterBencana;
        $filterFromDate =  $request->filterFromDate ?? null;
        $filterToDate = $request->filterToDate ?? null;

        if ($filter == 'Kematian') {
            $filter = '';
            $filterIdBencana = 37;
        } else if ($filter == 'Covid100'){
            $filter = '';
            $filterIdBencana = 38;
        }
        else if ($filter == 'BWI'){
            $filter = '';
            $filterIdBencana = 39;
        }
        else if ($filter == 'BWIKematian'){
            $filter = '';
            $filterIdBencana = 38;
        }
        
        // dd($filterIdBencana);
        $columns = [
            'tbl_mangsa.id', 'nama', 'no_kp', 'nama_negeri', 'nama_agensi', 'status_verifikasi', 'tbl_mangsa.tarikh_cipta','id_bencana'
        ];

        // $data = DB::table('tbl_mangsa')
        //     ->join('ref_negeri', 'tbl_mangsa.id_negeri', 'ref_negeri.id')
        //     ->join('ref_agensi', 'tbl_mangsa.id_agensi', 'ref_agensi.id')
        //     ->select('tbl_mangsa.id', 'nama', 'no_kp',  'nama_negeri', 'nama_agensi', 'status_verifikasi', 'tbl_mangsa.tarikh_cipta',
        //             DB::raw("(select count(id) as isi_rumah from tbl_mangsa_air where id_mangsa = tbl_mangsa.id),
        //             (coalesce((select sum(kos_sebenar) from tbl_mangsa_rumah where id_mangsa = tbl_mangsa.id), 0.00) +
        //             coalesce((select sum(kos_bantuan) from tbl_mangsa_bantuan where id_mangsa = tbl_mangsa.id), 0.00) +
        //             coalesce((select sum(jumlah_pinjaman) from tbl_mangsa_pinjaman where id_mangsa = tbl_mangsa.id), 0.00) +
        //             coalesce((select sum(kos_bantuan) from tbl_mangsa_pertanian where id_mangsa = tbl_mangsa.id), 0.00) +
        //             coalesce((select sum(jumlah) from tbl_mangsa_wang_ihsan where id_mangsa = tbl_mangsa.id), 0.00) +
        //             coalesce((select sum(kos_bantuan) from tbl_mangsa_antarabangsa where id_mangsa = tbl_mangsa.id), 0.00))
        //             as jumlah_bantuan")
        //         )
        //     ->where(function ($query) use ($filter, $columns) {
        //         $query->when($filter, function ($query, $filter) use ($columns) {
        //             foreach ($columns as $column) {
        //                 $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
        //             }
        //             return $query;
        //         });
        //     })
        //     ->where(function($query) use ($filterNegeri){
        //         $query->when($filterNegeri, function($query, $filterNegeri){
        //             return $query->where('id_negeri', $filterNegeri);
        //         });
        //     })
        //     ->where(function($query) use ($filterAgensi){
        //         $query->when($filterAgensi, function($query, $filterAgensi){
        //             return $query->where('id_agensi', $filterAgensi);
        //         });
        //     })
        //     ->where(function($query) use ($filterFromDate){
        //         $query->when($filterFromDate, function($query, $filterFromDate){
        //             return $query->whereDate('tbl_mangsa.tarikh_cipta', '>=', Carbon::parse($filterFromDate)->startOfDay());
        //         });
        //     })
        //     ->where(function($query) use ($filterToDate){
        //         $query->when($filterToDate, function($query, $filterToDate){
        //             return $query->whereDate('tbl_mangsa.tarikh_cipta', '<=', Carbon::parse($filterToDate)->endOfDay());
        //         });
        //     });
    
        /*
        if($negeri_to_search == "SABAH") {
            $data = DB::table('tbl_mangsa')
            ->join('ref_negeri', 'tbl_mangsa.id_negeri', '=', 'ref_negeri.id')
            ->join('ref_agensi', 'tbl_mangsa.id_agensi', '=', 'ref_agensi.id')
            ->join('tbl_mangsa_bencana', 'tbl_mangsa.id', '=', 'tbl_mangsa_bencana.id_mangsa') // Added join
            ->select('tbl_mangsa.id', 'nama', 'no_kp', 'nama_negeri', 'nama_agensi', 'status_verifikasi', 'tbl_mangsa.tarikh_cipta',
                'tbl_mangsa_bencana.id_bencana', // Added column
                DB::raw("(select count(id) as isi_rumah from tbl_mangsa_air where  negeri LIKE 'SABAH' AND  id_mangsa = tbl_mangsa.id),
                (coalesce((select sum(kos_sebenar) from tbl_mangsa_rumah where negeri LIKE 'SABAH' AND  id_mangsa = tbl_mangsa.id), 0.00) +
                coalesce((select sum(kos_bantuan) from tbl_mangsa_bantuan where negeri LIKE 'SABAH' AND id_mangsa = tbl_mangsa.id), 0.00) +
                coalesce((select sum(jumlah_pinjaman) from tbl_mangsa_pinjaman where negeri LIKE 'SABAH' AND  id_mangsa = tbl_mangsa.id), 0.00) +
                coalesce((select sum(kos_bantuan) from tbl_mangsa_pertanian where negeri LIKE 'SABAH' AND  id_mangsa = tbl_mangsa.id), 0.00) +
                coalesce((select sum(jumlah) from tbl_mangsa_wang_ihsan where negeri LIKE 'SABAH' AND  id_mangsa = tbl_mangsa.id), 0.00) +
                coalesce((select sum(kos_bantuan) from tbl_mangsa_antarabangsa where negeri LIKE 'SABAH' AND  id_mangsa = tbl_mangsa.id), 0.00))
                as jumlah_bantuan")
            )
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function($query) use ($filterNegeri){
                $query->when($filterNegeri, function($query, $filterNegeri){
                    return $query->where('id_negeri', $filterNegeri);
                });
            })
            ->where(function($query) use ($filterAgensi){
                $query->when($filterAgensi, function($query, $filterAgensi){
                    return $query->where('id_agensi', $filterAgensi);
                });
            })
            ->where(function($query) use ($filterFromDate){
                $query->when($filterFromDate, function($query, $filterFromDate){
                    return $query->whereDate('tbl_mangsa.tarikh_cipta', '>=', Carbon::parse($filterFromDate)->startOfDay());
                });
            })
            ->where(function($query) use ($filterToDate){
                $query->when($filterToDate, function($query, $filterToDate){
                    return $query->whereDate('tbl_mangsa.tarikh_cipta', '<=', Carbon::parse($filterToDate)->endOfDay());
                });
            });
        } else {
            $data = DB::table('tbl_mangsa')
                    ->join('ref_negeri', 'tbl_mangsa.id_negeri', '=', 'ref_negeri.id')
                    ->join('ref_agensi', 'tbl_mangsa.id_agensi', '=', 'ref_agensi.id')
                    ->join('tbl_mangsa_bencana', 'tbl_mangsa.id', '=', 'tbl_mangsa_bencana.id_mangsa') // Added join
                    ->select('tbl_mangsa.id', 'nama', 'no_kp', 'nama_negeri', 'nama_agensi', 'status_verifikasi', 'tbl_mangsa.tarikh_cipta',
                        'tbl_mangsa_bencana.id_bencana', // Added column
                        DB::raw("(select count(id) as isi_rumah from tbl_mangsa_air where id_mangsa = tbl_mangsa.id),
                        (coalesce((select sum(kos_sebenar) from tbl_mangsa_rumah where id_mangsa = tbl_mangsa.id), 0.00) +
                        coalesce((select sum(kos_bantuan) from tbl_mangsa_bantuan where id_mangsa = tbl_mangsa.id), 0.00) +
                        coalesce((select sum(jumlah_pinjaman) from tbl_mangsa_pinjaman where id_mangsa = tbl_mangsa.id), 0.00) +
                        coalesce((select sum(kos_bantuan) from tbl_mangsa_pertanian where id_mangsa = tbl_mangsa.id), 0.00) +
                        coalesce((select sum(jumlah) from tbl_mangsa_wang_ihsan where id_mangsa = tbl_mangsa.id), 0.00) +
                        coalesce((select sum(kos_bantuan) from tbl_mangsa_antarabangsa where id_mangsa = tbl_mangsa.id), 0.00))
                        as jumlah_bantuan")
                    )
                    ->where(function ($query) use ($filter, $columns) {
                        $query->when($filter, function ($query, $filter) use ($columns) {
                            foreach ($columns as $column) {
                                $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                            }
                            return $query;
                        });
                    })
                    ->where(function($query) use ($filterNegeri){
                        $query->when($filterNegeri, function($query, $filterNegeri){
                            return $query->where('id_negeri', $filterNegeri);
                        });
                    })
                    ->where(function($query) use ($filterAgensi){
                        $query->when($filterAgensi, function($query, $filterAgensi){
                            return $query->where('id_agensi', $filterAgensi);
                        });
                    })
                    ->where(function($query) use ($filterFromDate){
                        $query->when($filterFromDate, function($query, $filterFromDate){
                            return $query->whereDate('tbl_mangsa.tarikh_cipta', '>=', Carbon::parse($filterFromDate)->startOfDay());
                        });
                    })
                    ->where(function($query) use ($filterToDate){
                        $query->when($filterToDate, function($query, $filterToDate){
                            return $query->whereDate('tbl_mangsa.tarikh_cipta', '<=', Carbon::parse($filterToDate)->endOfDay());
                        });
                    });
        }
        */
        
        $data = DB::table('tbl_mangsa')
                    ->join('ref_negeri', 'tbl_mangsa.id_negeri', '=', 'ref_negeri.id')
                    ->join('ref_agensi', 'tbl_mangsa.id_agensi', '=', 'ref_agensi.id')
                    ->join('tbl_mangsa_bencana', 'tbl_mangsa.id', '=', 'tbl_mangsa_bencana.id_mangsa') // Added join
                    ->select('tbl_mangsa.id', 'nama', 'no_kp', 'nama_negeri', 'nama_agensi', 'status_verifikasi', 'tbl_mangsa.tarikh_cipta',
                        'tbl_mangsa_bencana.id_bencana', // Added column
                        DB::raw("(select count(id) as isi_rumah from tbl_mangsa_air where id_mangsa = tbl_mangsa.id),
                        (coalesce((select sum(kos_sebenar) from tbl_mangsa_rumah where id_mangsa = tbl_mangsa.id), 0.00) +
                        coalesce((select sum(kos_bantuan) from tbl_mangsa_bantuan where id_mangsa = tbl_mangsa.id), 0.00) +
                        coalesce((select sum(jumlah_pinjaman) from tbl_mangsa_pinjaman where id_mangsa = tbl_mangsa.id), 0.00) +
                        coalesce((select sum(kos_bantuan) from tbl_mangsa_pertanian where id_mangsa = tbl_mangsa.id), 0.00) +
                        coalesce((select sum(jumlah) from tbl_mangsa_wang_ihsan where id_mangsa = tbl_mangsa.id), 0.00) +
                        coalesce((select sum(kos_bantuan) from tbl_mangsa_antarabangsa where id_mangsa = tbl_mangsa.id), 0.00))
                        as jumlah_bantuan")
                    )
                    ->where(function ($query) use ($filter, $columns) {
                        $query->when($filter, function ($query, $filter) use ($columns) {
                            foreach ($columns as $column) {
                                $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                            }
                            return $query;
                        });
                    })
                    ->where(function($query) use ($filterNegeri){
                        $query->when($filterNegeri, function($query, $filterNegeri){
                            return $query->where('id_negeri', $filterNegeri);
                        });
                    })
                    ->where(function($query) use ($filterAgensi){
                        $query->when($filterAgensi, function($query, $filterAgensi){
                            return $query->where('id_agensi', $filterAgensi);
                        });
                    })
                    ->where(function($query) use ($filterIdBencana){
                        $query->when($filterIdBencana, function($query, $filterIdBencana){
                            return $query->where('id_bencana', $filterIdBencana);
                        });
                    })  
                    ->where(function($query) use ($filterFromDate){
                        $query->when($filterFromDate, function($query, $filterFromDate){
                            return $query->whereDate('tbl_mangsa.tarikh_cipta', '>=', Carbon::parse($filterFromDate)->startOfDay());
                        });
                    })
                    ->where(function($query) use ($filterToDate){
                        $query->when($filterToDate, function($query, $filterToDate){
                            return $query->whereDate('tbl_mangsa.tarikh_cipta', '<=', Carbon::parse($filterToDate)->endOfDay());
                        });
                    });

                    // dd($data);


        $totalCount = $data->count();
        // dd($data);

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
            'total_count' => $totalCount,
            'items' => $result,
        ], 200);
    }


    public function getMangsaForEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $mangsa = Mangsa::where('id', $request->id)->first();
        return response()->json(['mangsa' => $mangsa], 200);
    }

    public function getMangsaForDropdown(Request $request)
    {
        $filter = $request->filter;
        $filterNegeri = $request->filterNegeri;
        $filterAgensi = $request->filterAgensi;
        $filterFromDate =  $request->filterFromDate ?? null;
        $filterToDate = $request->filterToDate ?? null;

        $columns = [
            'tbl_mangsa.id', 'nama', 'no_kp', 'nama_negeri', 'nama_agensi', 'status_verifikasi', 'tbl_mangsa.tarikh_cipta'
        ];

        $data = DB::table('tbl_mangsa')
            ->join('ref_negeri', 'tbl_mangsa.id_negeri', 'ref_negeri.id')
            ->join('ref_agensi', 'tbl_mangsa.id_agensi', 'ref_agensi.id')
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            })
            ->where(function($query) use ($filterNegeri){
                $query->when($filterNegeri, function($query, $filterNegeri){
                    return $query->where('id_negeri', $filterNegeri);
                });
            })
            ->where(function($query) use ($filterAgensi){
                $query->when($filterAgensi, function($query, $filterAgensi){
                    return $query->where('id_agensi', $filterAgensi);
                });
            })
            ->where(function($query) use ($filterFromDate){
                $query->when($filterFromDate, function($query, $filterFromDate){
                    return $query->whereDate('tbl_mangsa.tarikh_cipta', '>=', Carbon::parse($filterFromDate)->startOfDay());
                });
            })
            ->where(function($query) use ($filterToDate){
                $query->when($filterToDate, function($query, $filterToDate){
                    return $query->whereDate('tbl_mangsa.tarikh_cipta', '<=', Carbon::parse($filterToDate)->endOfDay());
                });
            })
            ->select($columns)
            ->orderBy('id')
            ->get();

        return response()->json([
            'items'=> $data
        ], 200);
    }

    public function createOrEdit(Request $request)
    {
        $mangsa  = $request->mangsa;

        if ($mangsa['id'] ?? false) {
            $mangsa = $this->update($request);
        } else {
            $mangsa = $this->create($request);
        }

        return $mangsa;
    }

    private function create($request)
    {
        $validator = Validator::make($request->all(), [
            'mangsa.nama' => 'required|max:80',
            'mangsa.no_kp' => 'max:12',
            'mangsa.telefon' => 'required|max:15',
            'mangsa.alamat_1' => 'required|max:255',
            'mangsa.id_daerah' => 'required|numeric',
            'mangsa.id_negeri' => 'required|numeric',
            'mangsa.poskod' => 'required|max:5',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $mangsaInput = $request->mangsa;
        $bencanaInput = $request->bencana;
        $user = JWTAuth::user();

        try {
            DB::beginTransaction();
            $checkNoKp = Mangsa::where('no_kp', 'ILIKE', '%' . $mangsaInput['no_kp'] . '%')->first();
            if($checkNoKp){
                return response()->json([
                    'message' => 'No. Kad Pengenalan Sudah Didaftarkan. Sila Masukkan No. Kad Pengenalan Lain'
                ], 200);
            }
            else{
                $mangsa = Mangsa::create([
                    'nama' => $mangsaInput['nama'],
                    'no_kp' => $mangsaInput['no_kp'],
                    'telefon' => $mangsaInput['telefon'],
                    'alamat_1' => $mangsaInput['alamat_1'],
                    'alamat_2' => $mangsaInput['alamat_2'] ?? null,
                    'id_daerah' => $mangsaInput['id_daerah'],
                    'id_parlimen' => $mangsaInput['id_parlimen'] ?? null,
                    'id_dun' => $mangsaInput['id_dun'] ?? null,
                    'id_negeri' => $mangsaInput['id_negeri'],
                    'poskod' => $mangsaInput['poskod'],
                    'catatan' => $mangsaInput['catatan'] ?? null,
                    'status_mangsa' => 2,
                    'status_verifikasi' => $mangsaInput['status_verifikasi'],
                    'id_pengguna_cipta' => $user->id,
                    'tarikh_cipta' => Carbon::now(),
                    'id_agensi' => $user->id_agensi
                ]);
                $mangsa->save();
            }

            if($bencanaInput){
                $mangsaBencana = MangsaBencana::create([
                    'id_bencana' => $bencanaInput['id_bencana'],
                    'id_mangsa' => $mangsa->id,
                    'id_pindah' => $bencanaInput['id_pindah'],
                    'nama_pusat_pemindahan' => $bencanaInput['nama_pusat_pemindahan'] ?? null,
                    'masalah' => $bencanaInput['masalah'] ?? null,
                    'status_mangsa_bencana' => 2,
                    'id_pengguna_cipta' => $user->id,
                    'tarikh_cipta' => Carbon::now(),
                    'id_agensi' => $user->id_agensi
                ]);
                $mangsaBencana->save();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace(), 500);
        }

        return response()->json(['message' => 'Pendaftaran Mangsa Berjaya Disimpan!'], 200);
    }

    private function update($request)
    {
        $validator = Validator::make($request->all(), [
            'mangsa.nama' => 'required|max:80',
            'mangsa.no_kp' => 'max:12',
            'mangsa.telefon' => 'required|max:15',
            'mangsa.alamat_1' => 'required|max:255',
            'mangsa.id_daerah' => 'required|numeric',
            'mangsa.id_negeri' => 'required|numeric',
            'mangsa.poskod' => 'required|max:5','mangsa.nama' => 'required|max:80',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $mangsaInput = $request->mangsa;
        $mangsa = Mangsa::where('id', $mangsaInput['id'])->first();
        try {
            DB::beginTransaction();
            if($mangsa->no_kp != $mangsaInput['no_kp']){
                $checkNoKp = Mangsa::where('no_kp', 'ILIKE', '%' . $mangsaInput['no_kp'] . '%')->first();
                if($checkNoKp){
                    return response()->json([
                        'message' => 'No. Kad Pengenalan Sudah Didaftarkan. Sila Masukkan No. Kad Pengenalan Lain'
                    ], 200);
                }
            }

            $mangsa->nama = $mangsaInput['nama'];
            $mangsa->no_kp = $mangsaInput['no_kp'];
            $mangsa->telefon = $mangsaInput['telefon'];
            $mangsa->alamat_1 = $mangsaInput['alamat_1'];
            $mangsa->alamat_2 = $mangsaInput['alamat_2'] ?? null;
            $mangsa->id_daerah = $mangsaInput['id_daerah'];
            $mangsa->id_parlimen = $mangsaInput['id_parlimen'];
            $mangsa->id_dun = $mangsaInput['id_dun'];
            $mangsa->id_negeri = $mangsaInput['id_negeri'];
            $mangsa->poskod = $mangsaInput['poskod'];
            $mangsa->catatan = $mangsaInput['catatan'] ?? null;
            $mangsa->status_mangsa = $mangsaInput['status_mangsa'];
            $mangsa->status_verifikasi = $mangsaInput['status_verifikasi'];
            $mangsa->gambar = $mangsaInput['gambar'] ?? null;
            $mangsa->id_pengguna_kemaskini = JWTAuth::user()->id;
            $mangsa->tarikh_kemaskini = Carbon::now();

            $mangsa->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace(), 500);
        }
        return response()->json(['message' => 'Mangsa Berjaya Di Kemaskini!'], 200);
    }

    public function uploadGambarProfilMangsa(Request $request){
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|max:5120',
        ]);

        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 422);
        }

        $ext = $request->file('image')->extension();
        $fileName = Str::uuid().'.'.$ext;

        Storage::putFileAs(AppConst::ProfileMangsaStorage, $request->file('image'), $fileName);

        $filePath = Storage::url(AppConst::ProfileMangsaStorage.$fileName);
        return response()->json(['url'=> config('app.url').$filePath], 200);
    }

    public function multipleVerifikasi(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_mangsa' => 'required|array|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $user = JWTAuth::user();
        $idMangsa = $request->id_mangsa;

        try {
            DB::beginTransaction();

            foreach($idMangsa as $im){
                $mangsa = Mangsa::where('id', $im)->first();

                $mangsa->status_verifikasi = 1;
                $mangsa->id_pengguna_kemaskini = $user->id;
                $mangsa->tarikh_kemaskini = Carbon::now();
                $mangsa->save();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace(), 500);
        }
        return response()->json(['message' => 'Mangsa Telah Berjaya Diverifikasi'], 200);
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

            $mangsa = Mangsa::where('id', $request->id)->first();
            $mangsaBencana = MangsaBencana::where('id_mangsa', $mangsa->id)->get();

            $mangsaBencana->toArray();
            $mangsaCount =  count($mangsaBencana);

            if($mangsaCount > 0){
                return response()->json(["message" => "Mangsa ($mangsa->nama) Sudah Didaftarkan Di dalam Bencana"], 200);

            }else{
                $mangsaAir = DB::Table('tbl_mangsa_air')
                ->where('id_mangsa', $mangsa->id)
                ->get();

                foreach($mangsaAir as $ma){
                    $air = MangsaAir::where('id', $ma->id)->first();
                    $air->delete();
                }

                $mangsa->delete();
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace(), 500);
        }

        return response()->json(["message" => "Maklumat Mangsa Berjaya Dibuang"], 200);
    }

    public function uploadMangsa(Request $request){
        $validator = Validator::make($request->all(), [
            'excel' => 'required|mimes:xlsx',
        ]);

        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 422);
        }

        $user = JWTAuth::user();
        $ext = $request->file('excel')->extension();
        $fileName = Str::uuid().'_'.$user->id.'_'.now()->format('Ymd-His').'.'.$ext;
        Storage::putFileAs(AppConst::ExcelStorage.'import/', $request->file('excel'), $fileName);

        $mangsa = new MangsaImport($user);
        Excel::import($mangsa, 'import/'.$fileName, 'excel');

        return response()->json(['message' => 'File has been saved and queued for processing.']);
    }
}
