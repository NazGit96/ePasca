<?php

/**
 * Class PagedResultDtoOfRefTapakRumahForViewDto
 *
 * @OA\Schema(
 *     description="RefTapakRumah List in Tabular model",
 *     title="PagedResultDtoOfRefTapakRumahForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefTapakRumahForViewDto {

    /**
     * @OA\Property(
     *     description="Total Count",
     *     title="Total Count",
     * )
     *
     * @var integer
     */
    private $total_count;

    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/GetRefTapakRumahForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        