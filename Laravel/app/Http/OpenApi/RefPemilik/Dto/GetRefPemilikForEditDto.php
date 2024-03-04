<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefPemilikForEditDto
 *
 * @OA\Schema(
 *     title="GetRefPemilikForEditDto Schema"
 * )
 */
class GetRefPemilikForEditDto
{
    /**
     * @OA\Property(
     *     title="RefPemilik Model",
     *     ref="#/components/schemas/CreateOrEditRefPemilikDto"
     * )
     *
     * @var object
     */
    private $ref_pemilik;
}
