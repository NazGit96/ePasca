<?php

/**
 * Class PagedResultOfLaporanMangsaForViewDto
 *
 * @OA\Schema(
 *     description="Mangsa List in Tabular model",
 *     title="PagedResultOfLaporanMangsaForViewDto Schema",
 * )
 */
class PagedResultOfLaporanMangsaForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetMangsaLaporanDto")
     * )
     *
     * @var array
     */
    private $items;
}
