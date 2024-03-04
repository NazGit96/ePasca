<?php

/**
 * Class PagedResultOfLaporanMangsaBantuanLainForViewDto
 *
 * @OA\Schema(
 *     description="Mangsa List in Tabular model",
 *     title="PagedResultOfLaporanMangsaBantuanLainForViewDto Schema",
 * )
 */
class PagedResultOfLaporanMangsaBantuanLainForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetMangsaBantuanLainLaporanDto")
     * )
     *
     * @var array
     */
    private $items;

}
