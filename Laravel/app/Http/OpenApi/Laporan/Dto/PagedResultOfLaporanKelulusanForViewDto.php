<?php

/**
 * Class PagedResultOfLaporanKelulusanForViewDto
 *
 * @OA\Schema(
 *     description="Mangsa List in Tabular model",
 *     title="PagedResultOfLaporanKelulusanForViewDto Schema",
 * )
 */
class PagedResultOfLaporanKelulusanForViewDto {

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
     * )
     *
     * @var integer
     */
    private $total_siling_peruntukan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $total_peruntukan_diambil;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $total_belanja_covid_sebelum;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $total_belanja__bukan_covid_sebelum;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $total_skb_covid;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $total_skb_bukan_covid;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $total_terus_covid;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $total_terus_bukan_covid;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $total_belanja_covid_semasa;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $total_belanja__bukan_covid_semasa;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $total_waran;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $total_belanja;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $total_baki_peruntukan;

    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/InputLaporanKelulusanDto")
     * )
     *
     * @var array
     */
    private $items;
}
