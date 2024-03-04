<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefKategoriBayaranForEditDto
 *
 * @OA\Schema(
 *     title="GetRefKategoriBayaranForEditDto Schema"
 * )
 */
class GetRefKategoriBayaranForEditDto
{
    /**
     * @OA\Property(
     *     title="RefKategoriBayaran Model",
     *     ref="#/components/schemas/CreateOrEditRefKategoriBayaranDto"
     * )
     *
     * @var object
     */
    private $ref_kategori_bayaran;
}
