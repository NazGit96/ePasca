<?php

/**
 * Class PagedResultDtoOfTabungForViewDto
 *
 * @OA\Schema(
 *     description="Tabung List in Tabular model",
 *     title="PagedResultDtoOfTabungForViewDto Schema",
 * )
 */
class PagedResultDtoOfTabungForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetTabungForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        