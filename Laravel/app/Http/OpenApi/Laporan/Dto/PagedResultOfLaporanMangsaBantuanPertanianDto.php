<?php

/**
 * Class PagedResultOfLaporanMangsaBantuanPertanianForViewDto
 *
 * @OA\Schema(
 *     description="Mangsa List in Tabular model",
 *     title="PagedResultOfLaporanMangsaBantuanPertanianForViewDto Schema",
 * )
 */
class PagedResultOfLaporanMangsaBantuanPertanianForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetMangsaBantuanPertanianLaporanDto")
     * )
     *
     * @var array
     */
    private $items;

}
