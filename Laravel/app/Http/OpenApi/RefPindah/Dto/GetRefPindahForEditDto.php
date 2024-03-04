<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefPindahForEditDto
 *
 * @OA\Schema(
 *     title="GetRefPindahForEditDto Schema"
 * )
 */
class GetRefPindahForEditDto
{
    /**
     * @OA\Property(
     *     title="RefPindah Model",
     *     ref="#/components/schemas/CreateOrEditRefPindahDto"
     * )
     *
     * @var object
     */
    private $ref_pindah;
}
