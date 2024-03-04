<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefBantuanForEditDto
 *
 * @OA\Schema(
 *     title="GetRefBantuanForEditDto Schema"
 * )
 */
class GetRefBantuanForEditDto
{
    /**
     * @OA\Property(
     *     title="RefBantuan Model",
     *     ref="#/components/schemas/CreateOrEditRefBantuanDto"
     * )
     *
     * @var object
     */
    private $ref_bantuan;
}
