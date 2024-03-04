<?php

/**
 * Class PagedResultOfLaporanBwiKematianDto
 *
 * @OA\Schema(
 *     description="Mangsa List in Tabular model",
 *     title="PagedResultOfLaporanBwiKematianDto Schema",
 * )
 */
class PagedResultOfLaporanBwiKematianDto {

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
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/GetLaporanBwiKematianDto")
     * )
     *
     * @var array
     */
    private $items;
}
