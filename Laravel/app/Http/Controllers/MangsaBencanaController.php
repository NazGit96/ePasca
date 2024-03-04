<?php

namespace App\Http\Controllers;

use App\Models\Mangsa;
use App\Models\MangsaAntarabangsa;
use App\Models\MangsaBantuan;
use App\Models\MangsaBencana;
use App\Models\MangsaPertanian;
use App\Models\MangsaPinjaman;
use App\Models\MangsaRumah;
use App\Models\MangsaWangIhsan;
use App\Models\RefBencana;
use App\Models\RefBencanaNegeri;
use App\Models\RefNegeri;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class MangsaBencanaController extends Controller
{
    public function getAll(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;

        $columns = [
            'tbl_mangsa_bencana.id', 'id_bencana', 'id_mangsa', 'id_pindah', 'nama_pusat_pemindahan',
            'masalah', 'status_mangsa_bencana', 'id_pengguna_cipta', 'tarikh_cipta',
            'id_pengguna_kemaskini', 'tarikh_kemaskini', 'id_agensi', 'sebab_hapus', 'nama_bencana', 'pindah', 'tahun_bencana'
        ];

        $data = DB::table('tbl_mangsa_bencana')
            ->join('ref_bencana', 'tbl_mangsa_bencana.id_bencana', 'ref_bencana.id')
            ->leftJoin('ref_pindah', 'tbl_mangsa_bencana.id_pindah', 'ref_pindah.id')
            ->select($columns)
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            });

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
            'total_count' => $totalCount,
            'items' => $result
        ], 200);
    }

    public function getAllMangsaBencanaLookupTable(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id_bencana desc';
        $filter = $request->filter;
        $filterIdMangsa = $request->filterIdMangsa;

        $columns = [
            DB::raw('distinct id_bencana'), 'nama_bencana', 'tarikh_bencana', 'tahun_bencana'
        ];

        $data = DB::table('tbl_mangsa_bencana')
            ->join('ref_bencana', 'tbl_mangsa_bencana.id_bencana', 'ref_bencana.id')
            ->where('id_mangsa', $filterIdMangsa)
            ->select($columns)
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            });


        $result = $data
            ->when($sorting, function ($query, $sorting) {
                $sort = explode(" ", $sorting);
                return $query->orderBy($sort[0], $sort[1]);
            })->when($skipCount, function ($query, $skipCount) {
                return $query->skip($skipCount);
            })
            ->take($maxResultCount)
            ->get();

        $totalCount = $result->count();

        return response()->json([
            'total_count' => $totalCount,
            'items' => $result
        ], 200);
    }

    public function getAllByIdMangsa(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;

        $validator = Validator::make($request->all(), [
            'idMangsa' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $columns = [
            'tbl_mangsa_bencana.id', 'id_bencana', 'id_mangsa', 'id_pindah', 'nama_pusat_pemindahan',
            'masalah', 'status_mangsa_bencana', 'id_pengguna_cipta', 'tarikh_cipta',
            'id_pengguna_kemaskini', 'tarikh_kemaskini', 'id_agensi', 'sebab_hapus', 'nama_bencana', 'pindah', 'tarikh_bencana'
        ];

        $data = DB::table('tbl_mangsa_bencana')
            ->join('ref_bencana', 'tbl_mangsa_bencana.id_bencana', 'ref_bencana.id')
            ->leftJoin('ref_pindah', 'tbl_mangsa_bencana.id_pindah', 'ref_pindah.id')
            ->select($columns)
            ->where('id_mangsa', $request->idMangsa)
            ->where('status_mangsa_bencana', 2)
            ->where(function ($query) use ($filter, $columns) {
                $query->when($filter, function ($query, $filter) use ($columns) {
                    foreach ($columns as $column) {
                        $query->orWhere($column, 'ILIKE', '%' . $filter . '%');
                    }
                    return $query;
                });
            });

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
            'total_count' => $totalCount,
            'items' => $result
        ], 200);
    }

    public function getMangsaBencanaForEdit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $columns = [
            'tbl_mangsa_bencana.id', 'id_bencana', 'id_mangsa', 'id_pindah', 'nama_pusat_pemindahan', 'masalah', 'status_mangsa_bencana',
            'id_pengguna_cipta', 'tarikh_cipta', 'id_pengguna_kemaskini', 'tarikh_kemaskini', 'id_agensi', 'sebab_hapus', 'nama_bencana', 'tarikh_bencana'
        ];

        $mangsaBencana = DB::table('tbl_mangsa_bencana')
        ->join('ref_bencana', 'tbl_mangsa_bencana.id_bencana', 'ref_bencana.id')
        ->where('tbl_mangsa_bencana.id', $request->id)
        ->select($columns)
        ->first();

        return response()->json(['mangsa_bencana' => $mangsaBencana], 200);
    }

    public function multipleCreateMangsaBencana(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'mangsaBencana.id_bencana' => 'required|numeric',
            'id_mangsa' => 'required|array|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $user = JWTAuth::user();
        $idMangsaBencana = $request->id_mangsa;
        $mangsaBencana = $request->mangsaBencana;

        try {
            DB::beginTransaction();

            $bencana_negeri = RefBencanaNegeri::where('id_bencana', $mangsaBencana['id_bencana'])->pluck('id_negeri');
            $item_negeri = $bencana_negeri->toArray();

            foreach($idMangsaBencana as $mangsa_bencana){
                $mangsa = Mangsa::where('id', $mangsa_bencana)->first();

                if(in_array($mangsa->id_negeri, $item_negeri)){
                    $mangsaBencanaData = MangsaBencana::where('id_bencana', $mangsaBencana['id_bencana'])->where('id_mangsa', $mangsa_bencana)->first();

                    if($mangsaBencanaData == null){
                        $mangsaBencana = MangsaBencana::create([
                            'id_bencana' => $mangsaBencana['id_bencana'],
                            'id_mangsa' => $mangsa_bencana,
                            'id_pindah' => $mangsaBencana['id_pindah'],
                            'nama_pusat_pemindahan' => $mangsaBencana['nama_pusat_pemindahan'] ?? null,
                            'masalah' => $mangsaBencana['masalah'] ?? null,
                            'status_mangsa_bencana' => 2,
                            'id_pengguna_cipta' => $user->id,
                            'tarikh_cipta' => Carbon::now(),
                            'id_agensi' => $user->id_agensi
                        ]);

                        $mangsaBencana->save();
                    }

                }else{
                    $nama_negeri = RefNegeri::where('id', $mangsa->id_negeri)->first();

                    return response()->json(['message' => "Alamat Negeri ('$nama_negeri->nama_negeri') Bagi Mangsa '$mangsa->nama' ('$mangsa->no_kp') Tidak Terdapat Di Dalam Negeri Bencana Yang Didaftarkan"], 200);
                }
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace(), 500);
        }
        return response()->json(['message' => 'Pendaftaran Mangsa Bencana Berjaya Disimpan!'], 200);
    }

    public function createOrEdit(Request $request)
    {
        if ($request->id) {
            $mangsaBencana = $this->update($request);
        } else {
            $mangsaBencana = $this->create($request);
        }

        return $mangsaBencana;
    }

    private function create($request)
    {
        $validator = Validator::make($request->all(), [
            'id_bencana' => 'required|numeric',
            'id_mangsa' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $user = JWTAuth::user();

        try {
            DB::beginTransaction();
            $mangsaBencanaData = MangsaBencana::where('id_bencana', $request->id_bencana)->where('id_mangsa', $request->id_mangsa)->first();

            if($mangsaBencanaData){
                $bencana = RefBencana::where('id', $request->id_bencana)->first();
                return response()->json(['message' => "$bencana->nama_bencana ($bencana->tarikh_bencana) Sudah Didaftarkan"], 200);
            }else{
                $mangsaBencana = MangsaBencana::create([
                    'id_bencana' => $request->id_bencana,
                    'id_mangsa' => $request->id_mangsa,
                    'id_pindah' => $request->id_pindah,
                    'nama_pusat_pemindahan' => $request->nama_pusat_pemindahan,
                    'masalah' => $request->masalah,
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
        return response()->json(['message' => 'Pendaftaran Mangsa Bencana Berjaya Disimpan!'], 200);
    }

    private function update($request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'id_bencana' => 'required|numeric',
            'id_mangsa' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $mangsaBencana = MangsaBencana::where('id', $request->id)->first();

        try {
            DB::beginTransaction();
            $mangsaBencana->id_bencana = $request->id_bencana;
            $mangsaBencana->id_mangsa = $request->id_mangsa;
            $mangsaBencana->id_pindah = $request->id_pindah;
            $mangsaBencana->nama_pusat_pemindahan = $request->nama_pusat_pemindahan;
            $mangsaBencana->masalah = $request->masalah;
            $mangsaBencana->status_mangsa_bencana = $request->status_mangsa_bencana;
            $mangsaBencana->id_pengguna_kemaskini = JWTAuth::user()->id;
            $mangsaBencana->tarikh_kemaskini = Carbon::now();
            $mangsaBencana->save();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace(), 500);
        }
        return response()->json(['message' => 'Mangsa Bencana Berjaya Di Kemaskini!'], 200);
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

        $mangsaBencana = MangsaBencana::where('id', $request->id)->first();
        $mangsaBwi = MangsaWangIhsan::where('id_bencana', $mangsaBencana->id_bencana)->where('id_mangsa', $mangsaBencana->id_mangsa)->first();
        $mangsaAntarabangsa = MangsaAntarabangsa::where('id_bencana', $mangsaBencana->id_bencana)->where('id_mangsa', $mangsaBencana->id_mangsa)->first();
        $mangsaBantuan = MangsaBantuan::where('id_bencana', $mangsaBencana->id_bencana)->where('id_mangsa', $mangsaBencana->id_mangsa)->first();
        $mangsaPertanian = MangsaPertanian::where('id_bencana', $mangsaBencana->id_bencana)->where('id_mangsa', $mangsaBencana->id_mangsa)->first();
        $mangsaPinjaman = MangsaPinjaman::where('id_bencana', $mangsaBencana->id_bencana)->where('id_mangsa', $mangsaBencana->id_mangsa)->first();
        $mangsaRumah = MangsaRumah::where('id_bencana', $mangsaBencana->id_bencana)->where('id_mangsa', $mangsaBencana->id_mangsa)->first();
        $bencana = RefBencana::where('id', $mangsaBencana->id_bencana)->first();

        if($mangsaBwi){
            return response()->json(['message' => "$bencana->nama_bencana ($bencana->tarikh_bencana) Terdapat Di Dalam Mangsa Bantuan Wang Ihsan"], 200);

        }else if($mangsaRumah){
            return response()->json(['message' => "$bencana->nama_bencana ($bencana->tarikh_bencana) Terdapat Di Dalam Mangsa Bantuan Rumah"], 200);

        }else if($mangsaPinjaman){
            return response()->json(['message' => "$bencana->nama_bencana ($bencana->tarikh_bencana) Terdapat Di Dalam Mangsa Bantuan Pinjaman Khas"], 200);

        }else if($mangsaPertanian){
            return response()->json(['message' => "$bencana->nama_bencana ($bencana->tarikh_bencana) Terdapat Di Dalam Mangsa Bantuan Pertanian"], 200);

        }else if($mangsaAntarabangsa){
            return response()->json(['message' => "$bencana->nama_bencana ($bencana->tarikh_bencana) Terdapat Di Dalam Mangsa Bantuan Antarabangsa"], 200);

        }else if($mangsaBantuan){
            return response()->json(['message' => "$bencana->nama_bencana ($bencana->tarikh_bencana) Terdapat Di Dalam Mangsa Bantuan Lain"], 200);

        }
        else{
            $mangsaBencana->delete();
        }

        return response()->json(["message" => "Mangsa Bencana Berjaya Dibuang"], 200);
    }
}
