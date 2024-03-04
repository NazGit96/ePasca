<?php

/**
 * Class PagedResultDtoOfMangsaForViewDto
 *
 * @OA\Schema(
 *     description="Mangsa List in Tabular model",
 *     title="PagedResultDtoOfMangsaForViewDto Schema",
 * )
 */
class PagedResultDtoOfMangsaForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetMangsaForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
