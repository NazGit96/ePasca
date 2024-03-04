<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefRujukanForEditDto
 *
 * @OA\Schema(
 *     title="GetRefRujukanForEditDto Schema"
 * )
 */
class GetRefRujukanForEditDto
{
    /**
     * @OA\Property(
     *     title="RefRujukan Model",
     *     ref="#/components/schemas/CreateOrEditRefRujukanDto"
     * )
     *
     * @var object
     */
    private $ref_rujukan;
}
