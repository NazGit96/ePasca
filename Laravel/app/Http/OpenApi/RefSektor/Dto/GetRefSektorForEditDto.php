<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefSektorForEditDto
 *
 * @OA\Schema(
 *     title="GetRefSektorForEditDto Schema"
 * )
 */
class GetRefSektorForEditDto
{
    /**
     * @OA\Property(
     *     title="RefSektor Model",
     *     ref="#/components/schemas/CreateOrEditRefSektorDto"
     * )
     *
     * @var object
     */
    private $ref_sektor;
}
