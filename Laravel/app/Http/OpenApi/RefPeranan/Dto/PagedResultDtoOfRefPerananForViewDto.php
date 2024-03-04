<?php

/**
 * Class PagedResultDtoOfRefPerananForViewDto
 *
 * @OA\Schema(
 *     description="RefPeranan List in Tabular model",
 *     title="PagedResultDtoOfRefPerananForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefPerananForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefPerananForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        