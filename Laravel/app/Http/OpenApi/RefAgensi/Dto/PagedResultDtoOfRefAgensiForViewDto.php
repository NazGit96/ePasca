<?php

/**
 * Class PagedResultDtoOfRefAgensiForViewDto
 *
 * @OA\Schema(
 *     description="RefAgensi List in Tabular model",
 *     title="PagedResultDtoOfRefAgensiForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefAgensiForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefAgensiForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        