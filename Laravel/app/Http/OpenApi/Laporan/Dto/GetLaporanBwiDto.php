<?php

namespace app\Http\OpenApi;

/**
 * Class GetLaporanBwiDto
 *
 * @OA\Schema(
 *     title="GetLaporanBwiDto Schema"
 * )
 */
class GetLaporanBwiDto
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
    private $no_rujukan_bwi;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_negeri;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_daerah;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_bencana;


    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $bil_kir;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_keseluruhan;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $no_rujukan_akuan_kp;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_akuan_kp;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $no_rujukan_saluran_kpd_bkp;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_saluran_kpd_bkp;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_majlis_makluman_majlis;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $no_rujukan_makluman_majlis;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_makluman_majlis;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_eft;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $due_report;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_dipulangkan;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $no_rujukan_majlis_drp_apm;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_majlis_drp_apm;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $no_rujukan_laporan_kpd_bkp;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_laporan_kpd_bkp;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $catatan;
}
