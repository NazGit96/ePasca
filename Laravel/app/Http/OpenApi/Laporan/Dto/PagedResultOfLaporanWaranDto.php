<?php

/**
 * Class PagedResultOfLaporanWaranDto
 *
 * @OA\Schema(
 *     description="Mangsa List in Tabular model",
 *     title="PagedResultOfLaporanWaranDto Schema",
 * )
 */
class PagedResultOfLaporanWaranDto {

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
     *     description="Total Siling Waran",
     *     title="Total Siling Waran",
     * )
     *
     * @var integer
     */
    private $jumlah_siling_peruntukan;

    /**
     * @OA\Property(
     *     description="Total Baki Waran",
     *     title="Total Baki Waran",
     * )
     *
     * @var integer
     */
    private $jumlah_baki_peruntukan;

    /**
     * @OA\Property(
     *     description="Total Keseluruhan Waran",
     *     title="Total Keseluruhan Waran",
     * )
     *
     * @var integer
     */
    private $total_jumlah_keseluruhan;

    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/GetLaporanWaranDto")
     * )
     *
     * @var array
     */
    private $items;
}
