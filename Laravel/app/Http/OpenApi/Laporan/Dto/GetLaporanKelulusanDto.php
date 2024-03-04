<?php

namespace app\Http\OpenApi;

/**
 * Class GetLaporanKelulusanDto
 *
 * @OA\Schema(
 *     title="GetLaporanKelulusanDto Schema"
 * )
 */
class GetLaporanKelulusanDto
{

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $no_rujukan_kelulusan;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_surat;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $perihal_surat;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_mula_kelulusan;

     /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_tamat_kelulusan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_siling;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_diambil;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $baki_jumlah_siling;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $rujukan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_terus_covid_semasa;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_terus_bukan_covid_semasa;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_terus_covid_sebelum;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_terus_bukan_covid_sebelum;
}
