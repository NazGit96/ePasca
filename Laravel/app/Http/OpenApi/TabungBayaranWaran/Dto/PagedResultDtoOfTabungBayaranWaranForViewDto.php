<?php

/**
 * Class PagedResultDtoOfTabungBayaranWaranForViewDto
 *
 * @OA\Schema(
 *     description="TabungBayaranWaran List in Tabular model",
 *     title="PagedResultDtoOfTabungBayaranWaranForViewDto Schema",
 * )
 */
class PagedResultDtoOfTabungBayaranWaranForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetTabungBayaranWaranForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
