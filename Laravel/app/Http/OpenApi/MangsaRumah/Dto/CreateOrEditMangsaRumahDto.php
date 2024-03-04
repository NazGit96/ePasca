<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditMangsaRumahDto
 *
 * @OA\Schema(
 *     title="CreateOrEditMangsaRumahDto Schema"
 * )
 */
class CreateOrEditMangsaRumahDto
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
    private $id_bencana;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_mangsa;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_jenis_bantuan;

    /**
     * @OA\Property(
     * )
     *
     * @var boolean
     */
    private $naik_taraf;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_jenis_rumah;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_jenis_penempatan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_status_kerosakan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_pemilik;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_sumber_dana;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $sumber_dana_lain;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_pelaksana;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $pelaksana_lain;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $kontraktor;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $no_pkk;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $peratus_kemajuan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_status_kemajuan;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $geran_rumah;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $pemilik_tanah;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_tapak_rumah;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_mangsa_rumah;

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
    private $id_agensi;

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
    private $kos_anggaran;

      /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $kos_sebenar;

     /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_mula;

     /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_siap;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $catatan;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_bencana;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_bencana;
}
