<?php

/**
 * Class PagedResultDtoOfTabungBayaranSkbBulananForViewDto
 *
 * @OA\Schema(
 *     description="TabungBayaranSkbBulanan List in Tabular model",
 *     title="PagedResultDtoOfTabungBayaranSkbBulananForViewDto Schema",
 * )
 */
class PagedResultDtoOfTabungBayaranSkbBulananForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetTabungBayaranSkbBulananForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        