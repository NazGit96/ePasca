<?php

namespace App\Providers;

use App\Models\RefBencana;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('bencana', function($attribute, $value, $parameters, $validator) {
            $e = strtok($attribute, '.');
            $tarikh_bencana = Arr::get($validator->getData(), str_replace('*', $e, $parameters[0]));
            if(gettype($tarikh_bencana) == 'integer'){
                $date = intval($tarikh_bencana);
                $tarikh_bencana = Date::excelToDateTimeObject($date)->format('Y-m-d');
            }
            $refBencana = RefBencana::where('tarikh_bencana', $tarikh_bencana)->where('nama_bencana', 'ILIKE', $value)->first();

            $validator->addReplacer('bencana', function ($message, $attribute, $rule, $parameters) use ($value, $tarikh_bencana) {
                $str = str_replace(':value', $value, $message);
                return str_replace(':dateValue', $tarikh_bencana, $str);
            });
            if($refBencana){
                return true;
            }

            return false;
        });
    }
}
