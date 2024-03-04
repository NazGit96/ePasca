<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefWarganegaraForEditDto
 *
 * @OA\Schema(
 *     title="GetRefWarganegaraForEditDto Schema"
 * )
 */
class GetRefWarganegaraForEditDto
{
    /**
     * @OA\Property(
     *     title="RefWarganegara Model",
     *     ref="#/components/schemas/CreateOrEditRefWarganegaraDto"
     * )
     *
     * @var object
     */
    private $ref_warganegara;
}
