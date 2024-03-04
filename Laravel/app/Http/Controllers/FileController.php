<?php

namespace App\Http\Controllers;

use App\Http\AppConst;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use stdClass;

class FileController extends Controller
{
    public function downloadTempFile(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'file_type' => 'required',
            'file_name' => 'required',
            'file_token' => 'required'
        ]);

        if($validator->fails()){
            return response()->json(['message' => $validator->errors()], 422);
        }

        if(!Storage::exists(AppConst::TempStorage.$input['file_token'].'.'.$input['file_type'])){
            return response()->json(['message' => 'File does not exist!'], 500);
        }

        return response()->download(storage_path('app/public/temp/'.$input['file_token'].'.'.$input['file_type']), $input['file_name'])->deleteFileAfterSend(true);
    }
}
