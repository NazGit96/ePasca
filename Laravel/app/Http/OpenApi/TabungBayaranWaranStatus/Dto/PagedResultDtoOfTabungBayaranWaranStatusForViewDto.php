<?php

/**
 * Class PagedResultDtoOfTabungBayaranWaranStatusForViewDto
 *
 * @OA\Schema(
 *     description="TabungBayaranWaranStatus List in Tabular model",
 *     title="PagedResultDtoOfTabungBayaranWaranStatusForViewDto Schema",
 * )
 */
class PagedResultDtoOfTabungBayaranWaranStatusForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetTabungBayaranWaranStatusForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
