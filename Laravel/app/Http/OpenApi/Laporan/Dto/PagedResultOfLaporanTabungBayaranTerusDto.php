<?php

/**
 * Class PagedResultOfLaporanTabungBayaranTerusDto
 *
 * @OA\Schema(
 *     description="Mangsa List in Tabular model",
 *     title="PagedResultOfLaporanTabungBayaranTerusDto Schema",
 * )
 */
class PagedResultOfLaporanTabungBayaranTerusDto {

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
     *     description="Total Bayaran Terus",
     *     title="Total Bayaran Terus",
     * )
     *
     * @var integer
     */
    private $jumlah_bayaran_terus;

    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/GetLaporanBayaranTerusDto")
     * )
     *
     * @var array
     */
    private $items;
}
