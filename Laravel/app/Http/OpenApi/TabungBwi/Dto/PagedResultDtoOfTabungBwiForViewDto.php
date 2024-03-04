<?php

/**
 * Class PagedResultDtoOfTabungBwiForViewDto
 *
 * @OA\Schema(
 *     description="TabungBwi List in Tabular model",
 *     title="PagedResultDtoOfTabungBwiForViewDto Schema",
 * )
 */
class PagedResultDtoOfTabungBwiForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetTabungBwiForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        