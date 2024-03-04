<?php

/**
 * Class PagedResultOfLaporanBwiDto
 *
 * @OA\Schema(
 *     description="Mangsa List in Tabular model",
 *     title="PagedResultOfLaporanBwiDto Schema",
 * )
 */
class PagedResultOfLaporanBwiDto {

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
     *     description="Total Kir",
     *     title="Total Kir",
     * )
     *
     * @var integer
     */
    private $total_kir;

    /**
     * @OA\Property(
     *     description="Total Jumlah",
     *     title="Total Jumlah",
     * )
     *
     * @var integer
     */
    private $total_jumlah;

    /**
     * @OA\Property(
     *     description="Total Dipulangkan",
     *     title="Total Dipulangkan",
     * )
     *
     * @var integer
     */
    private $total_dipulangkan;

    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/GetLaporanBwiDto")
     * )
     *
     * @var array
     */
    private $items;
}
