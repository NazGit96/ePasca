<?php

/**
 * Class PagedResultOfLaporanSkbDto
 *
 * @OA\Schema(
 *     description="Mangsa List in Tabular model",
 *     title="PagedResultOfLaporanSkbDto Schema",
 * )
 */
class PagedResultOfLaporanSkbDto {

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
     *     description="Total Siling Skb",
     *     title="Total Siling Skb",
     * )
     *
     * @var integer
     */
    private $jumlah_siling_peruntukan;

    /**
     * @OA\Property(
     *     description="Total Baki Skb",
     *     title="Total Baki Skb",
     * )
     *
     * @var integer
     */
    private $jumlah_baki_peruntukan;

    /**
     * @OA\Property(
     *     description="Total Keseluruhan Skb",
     *     title="Total Keseluruhan Skb",
     * )
     *
     * @var integer
     */
    private $total_jumlah_keseluruhan;

    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/GetLaporanSkbDto")
     * )
     *
     * @var array
     */
    private $items;
}
