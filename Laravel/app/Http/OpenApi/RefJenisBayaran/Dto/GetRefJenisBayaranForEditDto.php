<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefJenisBayaranForEditDto
 *
 * @OA\Schema(
 *     title="GetRefJenisBayaranForEditDto Schema"
 * )
 */
class GetRefJenisBayaranForEditDto
{
    /**
     * @OA\Property(
     *     title="RefJenisBayaran Model",
     *     ref="#/components/schemas/CreateOrEditRefJenisBayaranDto"
     * )
     *
     * @var object
     */
    private $ref_jenis_bayaran;
}
