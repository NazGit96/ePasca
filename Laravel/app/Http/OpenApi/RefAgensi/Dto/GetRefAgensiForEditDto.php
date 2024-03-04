<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefAgensiForEditDto
 *
 * @OA\Schema(
 *     title="GetRefAgensiForEditDto Schema"
 * )
 */
class GetRefAgensiForEditDto
{
    /**
     * @OA\Property(
     *     title="RefAgensi Model",
     *     ref="#/components/schemas/CreateOrEditRefAgensiDto"
     * )
     *
     * @var object
     */
    private $ref_agensi;
}
