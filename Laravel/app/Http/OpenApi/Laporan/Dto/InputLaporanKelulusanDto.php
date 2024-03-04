<?php

namespace app\Http\OpenApi;

/**
 * Class InputLaporanKelulusanDto
 *
 * @OA\Schema(
 *     title="InputLaporanKelulusanDto Schema"
 * )
 */
class InputLaporanKelulusanDto
{
    /**
     * @OA\Property(
     *     title="RefBencana Model",
     *     ref="#/components/schemas/GetLaporanKelulusanDto"
     * )
     *
     * @var object
     */
    private $kelulusan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_skb_covid_semasa;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_skb_bukan_covid_semasa;

     /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_waran_semasa;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $belanja_covid_semasa;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $belanja_bukan_covid_semasa;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $belanja_covid_sebelum;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $belanja_bukan_covid_sebelum;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_belanja;
}
