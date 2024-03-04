<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditTabungBayaranWaranDto
 *
 * @OA\Schema(
 *     title="CreateOrEditTabungBayaranWaranDto Schema"
 * )
 */
class CreateOrEditTabungBayaranWaranDto
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
    private $no_rujukan_waran;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $rujukan_surat_waran;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_surat_waran;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_tabung_kelulusan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_agensi;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $perihal;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_siling_peruntukan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_baki_peruntukan;

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
    private $id_tabung;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_tabung_bayaran_waran_status;

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
     * @var string
     */
    private $nama_tabung;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_waran_status;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_status_waran;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $catatan;

}
