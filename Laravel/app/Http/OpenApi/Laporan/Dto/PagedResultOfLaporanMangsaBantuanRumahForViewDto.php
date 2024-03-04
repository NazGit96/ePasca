<?php

/**
 * Class PagedResultOfLaporanMangsaBantuanRumahForViewDto
 *
 * @OA\Schema(
 *     description="Mangsa List in Tabular model",
 *     title="PagedResultOfLaporanMangsaBantuanRumahForViewDto Schema",
 * )
 */
class PagedResultOfLaporanMangsaBantuanRumahForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetMangsaBantuanRumahLaporanDto")
     * )
     *
     * @var array
     */
    private $items;

}