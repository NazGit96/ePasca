<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefSumberPeruntukanForEditDto
 *
 * @OA\Schema(
 *     title="GetRefSumberPeruntukanForEditDto Schema"
 * )
 */
class GetRefSumberPeruntukanForEditDto
{
    /**
     * @OA\Property(
     *     title="RefSumberPeruntukan Model",
     *     ref="#/components/schemas/CreateOrEditRefSumberPeruntukanDto"
     * )
     *
     * @var object
     */
    private $ref_sumber_peruntukan;
}
