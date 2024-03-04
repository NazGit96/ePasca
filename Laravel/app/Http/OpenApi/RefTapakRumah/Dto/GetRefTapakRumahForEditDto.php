<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefTapakRumahForEditDto
 *
 * @OA\Schema(
 *     title="GetRefTapakRumahForEditDto Schema"
 * )
 */
class GetRefTapakRumahForEditDto
{
    /**
     * @OA\Property(
     *     title="RefTapakRumah Model",
     *     ref="#/components/schemas/CreateOrEditRefTapakRumahDto"
     * )
     *
     * @var object
     */
    private $ref_tapak_rumah;
}
