<?php

/**
 * Class PagedResultOfLaporanMangsaBantuanPinjamanForViewDto
 *
 * @OA\Schema(
 *     description="Mangsa List in Tabular model",
 *     title="PagedResultOfLaporanMangsaBantuanPinjamanForViewDto Schema",
 * )
 */
class PagedResultOfLaporanMangsaBantuanPinjamanForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetMangsaBantuanPinjamanLaporanDto")
     * )
     *
     * @var array
     */
    private $items;

}
