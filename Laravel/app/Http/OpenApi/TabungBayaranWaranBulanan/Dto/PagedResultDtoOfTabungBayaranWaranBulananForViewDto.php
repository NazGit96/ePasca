<?php

/**
 * Class PagedResultDtoOfTabungBayaranWaranBulananForViewDto
 *
 * @OA\Schema(
 *     description="TabungBayaranWaranBulanan List in Tabular model",
 *     title="PagedResultDtoOfTabungBayaranWaranBulananForViewDto Schema",
 * )
 */
class PagedResultDtoOfTabungBayaranWaranBulananForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetTabungBayaranWaranBulananForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
