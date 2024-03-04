<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefMukimForEditDto
 *
 * @OA\Schema(
 *     title="GetRefMukimForEditDto Schema"
 * )
 */
class GetRefMukimForEditDto
{
    /**
     * @OA\Property(
     *     title="RefMukim Model",
     *     ref="#/components/schemas/CreateOrEditRefMukimDto"
     * )
     *
     * @var object
     */
    private $ref_mukim;
}
