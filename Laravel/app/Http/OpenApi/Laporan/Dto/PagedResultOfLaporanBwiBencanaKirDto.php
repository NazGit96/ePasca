<?php

/**
 * Class PagedResultOfLaporanBwiBencanaKirDto
 *
 * @OA\Schema(
 *     description="Mangsa List in Tabular model",
 *     title="PagedResultOfLaporanBwiBencanaKirDto Schema",
 * )
 */
class PagedResultOfLaporanBwiBencanaKirDto {

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
     *     description="Total Peruntukan",
     *     title="Total Peruntukan",
     * )
     *
     * @var integer
     */
    private $total_peruntukan;

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
     *     description="Total Diagihkan",
     *     title="Total Diagihkan",
     * )
     *
     * @var integer
     */
    private $total_diagihkan;

    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/GetLaporanBwiBencanaKirDto")
     * )
     *
     * @var array
     */
    private $items;
}
