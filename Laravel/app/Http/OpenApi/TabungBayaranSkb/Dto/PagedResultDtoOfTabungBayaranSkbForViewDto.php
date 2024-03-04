<?php

/**
 * Class PagedResultDtoOfTabungBayaranSkbForViewDto
 *
 * @OA\Schema(
 *     description="TabungBayaranSkb List in Tabular model",
 *     title="PagedResultDtoOfTabungBayaranSkbForViewDto Schema",
 * )
 */
class PagedResultDtoOfTabungBayaranSkbForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetTabungBayaranSkbForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        