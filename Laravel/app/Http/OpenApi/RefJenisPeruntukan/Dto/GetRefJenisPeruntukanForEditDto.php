<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefJenisPeruntukanForEditDto
 *
 * @OA\Schema(
 *     title="GetRefJenisPeruntukanForEditDto Schema"
 * )
 */
class GetRefJenisPeruntukanForEditDto
{
    /**
     * @OA\Property(
     *     title="RefJenisPeruntukan Model",
     *     ref="#/components/schemas/CreateOrEditRefJenisPeruntukanDto"
     * )
     *
     * @var object
     */
    private $ref_jenis_peruntukan;
}
