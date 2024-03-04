<?php

namespace App\Imports;

use App\Http\Controllers\MailController;
use App\Http\Excels\Errors\MangsaExportFailureExcel;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Throwable;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Facades\Excel;

abstract class ToCollectionImport implements ToCollection
{
    abstract public function processImport(Collection $rows);

    abstract public function rules(): array;

    abstract public function validationMessages(): array;

    abstract public function user();

    use SkipsFailures, SkipsErrors;

    /**
     * @param Collection $rows
     */
    public function collection(Collection $rows)
    {
        if ($this instanceof WithValidation) {
            $rows = $this->validate($rows);
        }

        try {
            $this->processImport($rows);
        } catch (Throwable $e) {
            $this->recordOrThrowErrors($e);
        }

        if ($this->failures()->count() > 0) {

            $getAllFailures = $this->failures()->map(function ($item) {
                return ['row' => $item->row(), 'attribute' => $item->attribute(), 'errors' => implode(',',$item->errors())];
            })->sortBy('row')->groupBy('row');
            $file_name = Str::random(16) .'_'. now()->format('Ymd-His');
            Excel::store(new MangsaExportFailureExcel($getAllFailures), 'errors/'.$file_name.'.xlsx', 'excel');

            $mail_controller = new MailController;
            $mail_controller->failureMangsaImport($this->user()->nama, $this->user()->emel, $this->failures()->count(), $file_name.'.xlsx');
        }

        if($this->failures()->count() === 0){
            $mail_controller = new MailController;
            $mail_controller->successMangsaImport($this->user()->nama, $this->user()->emel,);
        }

        if ($this->errors()->count() > 0) {
            Log::error($this->errors());
        }
    }

    /**
     * Validate given collection data.
     *
     * @param Collection $rows
     *
     * @throws ValidationException
     *
     * @return Collection
     */
    protected function validate(Collection $rows)
    {
        $validator = Validator::make($rows->toArray(), $this->rules(), $this->validationMessages());

        if (! $validator->fails()) {
            return $rows;
        }

        if ($this instanceof SkipsOnFailure) {
            $this->failures = [];
            $this->onFailure(
                ...$this->collectErrors($validator, $rows)
            );

            $keysCausingFailure = collect($validator->errors()->keys())->map(function ($key) {
                return Str::before($key, '.');
            })
            ->values()
            ->toArray();

            return $rows->except($keysCausingFailure);
        }

        throw new ValidationException($validator);
    }

    /**
     * Get all validation errors.
     *
     * @param $validator
     * @param Collection $rows
     *
     * @return array
     */
    protected function collectErrors(ValidationValidator $validator, Collection $rows)
    {
        $failures = [];

        $errors = $validator->errors()->toArray();
        foreach ($errors as $attribute => $messages) {
            $row = strtok($attribute, '.');
            $attributeName = strtok('');
            $attributeName = $attributes['*.' . $attributeName] ?? $attributeName;
            array_push($failures, new Failure(
                $row+2,
                Str::title(str_replace('_', ' ', $attributeName)),
                str_replace($attribute, $attributeName, $messages),
                $rows->toArray()[$row]
            ));
        }
        return $failures;
    }

    /**
     * Records an error or throws its exception.
     *
     * @param Throwable $error
     *
     * @throws \Exception
     */
    protected function recordOrThrowErrors(Throwable $error)
    {
        if ($this instanceof SkipsOnError) {
            return $this->onError($error);
        }

        throw $error;
    }
}
