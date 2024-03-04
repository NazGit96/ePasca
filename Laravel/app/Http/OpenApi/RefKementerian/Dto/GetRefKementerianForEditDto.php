<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefKementerianForEditDto
 *
 * @OA\Schema(
 *     title="GetRefKementerianForEditDto Schema"
 * )
 */
class GetRefKementerianForEditDto
{
    /**
     * @OA\Property(
     *     title="RefKementerian Model",
     *     ref="#/components/schemas/CreateOrEditRefKementerianDto"
     * )
     *
     * @var object
     */
    private $ref_kementerian;
}
