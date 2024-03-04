<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefPerananForEditDto
 *
 * @OA\Schema(
 *     title="GetRefPerananForEditDto Schema"
 * )
 */
class GetRefPerananForEditDto
{
    /**
     * @OA\Property(
     *     title="RefPeranan Model",
     *     ref="#/components/schemas/CreateOrEditRefPerananDto"
     * )
     *
     * @var object
     */
    private $ref_peranan;
}
