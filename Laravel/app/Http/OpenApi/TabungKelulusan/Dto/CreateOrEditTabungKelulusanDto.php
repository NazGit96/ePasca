<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditTabungKelulusanDto
 *
 * @OA\Schema(
 *     title="CreateOrEditTabungKelulusanDto Schema"
 * )
 */
class CreateOrEditTabungKelulusanDto
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
     * )
     *
     * @var integer
     */
    private $id_tabung;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_bantuan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_komitmen;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $rujukan_surat;

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
     * @var integer
     */
    private $jumlah_siling;

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
     * @var integer
     */
    private $status_tabung_kelulusan;

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
     * @var string
     */
    private $perihal_surat;

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
     * @var boolean
     */
    private $hapus;

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
     * )
     *
     * @var integer
     */
    private $jumlah_dipulangkan;
}
