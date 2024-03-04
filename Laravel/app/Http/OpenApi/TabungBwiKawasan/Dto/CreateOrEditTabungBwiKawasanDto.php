<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditTabungBwiKawasanDto
 *
 * @OA\Schema(
 *     title="CreateOrEditTabungBwiKawasanDto Schema"
 * )
 */
class CreateOrEditTabungBwiKawasanDto
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
     * @var integer
     */
    private $id_tabung_bwi;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_daerah;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_negeri;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_bwi;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_kir;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_kembali;


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
     * )
     *
     * @var string
     */
    private $catatan;

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
    private $tarikh_majlis_makluman_majlis;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_pengguna_cipta;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_cipta;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_pengguna_kemaskini;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_kemaskini;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_pengguna_hapus;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_hapus;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $sebab_hapus;

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

}
