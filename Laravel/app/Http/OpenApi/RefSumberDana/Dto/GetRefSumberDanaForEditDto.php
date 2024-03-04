<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefSumberDanaForEditDto
 *
 * @OA\Schema(
 *     title="GetRefSumberDanaForEditDto Schema"
 * )
 */
class GetRefSumberDanaForEditDto
{
    /**
     * @OA\Property(
     *     title="RefSumberDana Model",
     *     ref="#/components/schemas/CreateOrEditRefSumberDanaDto"
     * )
     *
     * @var object
     */
    private $ref_sumber_dana;
}
