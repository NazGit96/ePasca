<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefPinjamanPerniagaanForEditDto
 *
 * @OA\Schema(
 *     title="GetRefPinjamanPerniagaanForEditDto Schema"
 * )
 */
class GetRefPinjamanPerniagaanForEditDto
{
    /**
     * @OA\Property(
     *     title="RefPinjamanPerniagaan Model",
     *     ref="#/components/schemas/CreateOrEditRefPinjamanPerniagaanDto"
     * )
     *
     * @var object
     */
    private $ref_pinjaman_perniagaan;
}
