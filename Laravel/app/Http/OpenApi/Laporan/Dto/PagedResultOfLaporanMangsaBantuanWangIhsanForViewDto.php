<?php

/**
 * Class PagedResultOfLaporanMangsaBantuanWangIhsanForViewDto
 *
 * @OA\Schema(
 *     description="Mangsa List in Tabular model",
 *     title="PagedResultOfLaporanMangsaBantuanWangIhsanForViewDto Schema",
 * )
 */
class PagedResultOfLaporanMangsaBantuanWangIhsanForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetMangsaBantuanWangIhsanLaporanDto")
     * )
     *
     * @var array
     */
    private $items;

}
