<?php

namespace App\Http\Controllers;

use App\Models\MangsaAntarabangsa;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;

class MangsaAntarabangsaController extends Controller
{
    public function getAll(Request $request)
    {
        $maxResultCount = $request->maxResultCount ?? 10;
        $skipCount = $request->skipCount;
        $sorting = $request->sorting ?? 'id desc';
        $filter = $request->filter;

        $columns = [
            'tbl_mangsa_antarabangsa.id', 'id_bencana', 'id_mangsa', 'nama_bantuan', 'negara', 'kos_bantuan',
            'tarikh_bantuan', 'tbl_mangsa_antarabangsa.catatan', 'sebab_hapus', 'status_mangsa_antarabangsa',
            'id_pengguna_cipta', 'tarikh_cipta', 'id_agensi', 'id_pengguna_kemaskini',
            'tarikh_kemaskini', 'nama_bencana',  'tarikh_bencana'
        ];

        $data = DB::table('tbl_mangsa_antarabangsa')
            ->join('ref_bencana', 'tbl_mangsa_antarabangsa.id_bencana', 'ref_bencana.id')
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
            'tbl_mangsa_antarabangsa.id', 'id_bencana', 'id_mangsa', 'nama_bantuan', 'negara', 'kos_bantuan',
            'tarikh_bantuan', 'tbl_mangsa_antarabangsa.catatan', 'sebab_hapus', 'status_mangsa_antarabangsa',
            'id_pengguna_cipta', 'tarikh_cipta', 'id_agensi', 'id_pengguna_kemaskini',
            'tarikh_kemaskini', 'nama_bencana',  'tarikh_bencana'
        ];

        $data = DB::table('tbl_mangsa_antarabangsa')
            ->join('ref_bencana', 'tbl_mangsa_antarabangsa.id_bencana', 'ref_bencana.id')
            ->select($columns)
            ->where('id_mangsa', $request->idMangsa)
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

    public function getMangsaAntarabangsaForEdit(Request $request)
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
            'tbl_mangsa_antarabangsa.id', 'id_bencana', 'id_mangsa', 'nama_bantuan', 'negara', 'kos_bantuan', 'tarikh_bantuan', 'tbl_mangsa_antarabangsa.catatan',
            'sebab_hapus', 'status_mangsa_antarabangsa', 'id_pengguna_cipta', 'tarikh_cipta', 'id_agensi',
            'id_pengguna_kemaskini', 'tarikh_kemaskini', 'nama_bencana', 'tarikh_bencana'
        ];

        $mangsaAntarabangsa = DB::table('tbl_mangsa_antarabangsa')
        ->join('ref_bencana', 'tbl_mangsa_antarabangsa.id_bencana', 'ref_bencana.id')
        ->where('tbl_mangsa_antarabangsa.id', $request->id)
        ->select($columns)
        ->first();

        return response()->json(['mangsa_antarabangsa' => $mangsaAntarabangsa], 200);
    }

    public function createOrEdit(Request $request)
    {
        if ($request->id) {
            $mangsaAntarabangsa = $this->update($request);
        } else {
            $mangsaAntarabangsa = $this->create($request);
        }

        return $mangsaAntarabangsa;
    }

    private function create($request)
    {
        $validator = Validator::make($request->all(), [
            'id_bencana' => 'required|numeric',
            'id_mangsa' => 'required|numeric',
            'nama_bantuan' => 'required|max:255',
            'negara' => 'required|max:255',
            'kos_bantuan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $user = JWTAuth::user();

        try {
            DB::beginTransaction();
            $mangsaAntarabangsa = MangsaAntarabangsa::create([
                'id_bencana' => $request->id_bencana,
                'id_mangsa' => $request->id_mangsa,
                'nama_bantuan' => $request->nama_bantuan,
                'negara' => $request->negara,
                'kos_bantuan' => $request->kos_bantuan,
                'tarikh_bantuan' => $request->tarikh_bantuan,
                'catatan' => $request->catatan,
                'status_mangsa_antarabangsa' => 2,
                'id_pengguna_cipta' => $user->id,
                'tarikh_cipta' => Carbon::now(),
                'id_agensi' => $user->id_agensi
            ]);

            $mangsaAntarabangsa->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace(), 500);
        }

        return response()->json(['message' => 'Pendaftaran Bantuan Antarabangsa Berjaya Disimpan!'], 200);
    }

    private function update($request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required',
            'id_bencana' => 'required|numeric',
            'id_mangsa' => 'required|numeric',
            'nama_bantuan' => 'required|max:255',
            'negara' => 'required|max:255',
            'kos_bantuan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()
            ], 422);
        }

        $mangsaAntarabangsa = MangsaAntarabangsa::where('id', $request->id)->first();
        try {
            DB::beginTransaction();
            $mangsaAntarabangsa->id_bencana = $request->id_bencana;
            $mangsaAntarabangsa->id_mangsa = $request->id_mangsa;
            $mangsaAntarabangsa->nama_bantuan = $request->nama_bantuan;
            $mangsaAntarabangsa->negara = $request->negara;
            $mangsaAntarabangsa->kos_bantuan = $request->kos_bantuan;
            $mangsaAntarabangsa->tarikh_bantuan = $request->tarikh_bantuan;
            $mangsaAntarabangsa->catatan = $request->catatan;
            $mangsaAntarabangsa->sebab_hapus = $request->sebab_hapus;
            $mangsaAntarabangsa->status_mangsa_antarabangsa = $request->status_mangsa_antarabangsa;
            $mangsaAntarabangsa->id_pengguna_kemaskini = JWTAuth::user()->id;
            $mangsaAntarabangsa->tarikh_kemaskini = Carbon::now();

            $mangsaAntarabangsa->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json($e->getTrace(), 500);
        }

        return response()->json(['message' => 'Bantuan Antarabangsa Berjaya Di Kemaskini!'], 200);
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

        $bantuanAntarabangsa = MangsaAntarabangsa::where('id', $request->id)->first();

        $bantuanAntarabangsa->delete();

        return response()->json(["message" => "Bantuan Antarabangsa Berjaya Dibuang"], 200);
    }
}
