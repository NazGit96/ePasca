<?php

/**
 * Class GetRefTapakRumahForListDto
 *
 * @OA\Schema(
 *     description="RefTapakRumah List in Tabular model",
 *     title="GetRefTapakRumahForListDto Schema",
 * )
 */
class GetRefTapakRumahForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefTapakRumahDto")
     * )
     *
     * @var array
     */
    private $items;
}
        