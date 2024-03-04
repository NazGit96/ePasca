<?php

/**
 * Class PagedResultDtoOfTabungBayaranTerusForViewDto
 *
 * @OA\Schema(
 *     description="TabungBayaranTerus List in Tabular model",
 *     title="PagedResultDtoOfTabungBayaranTerusForViewDto Schema",
 * )
 */
class PagedResultDtoOfTabungBayaranTerusForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetTabungBayaranTerusForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        