<?php

namespace app\Http\OpenApi;

/**
 * Class GetMangsaPertanianForViewDto
 *
 * @OA\Schema(
 *     title="GetMangsaPertanianForViewDto Schema"
 * )
 */
class GetMangsaPertanianForViewDto
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
    private $id_agensi_bantuan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_jenis_pertanian;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $luas;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $luas_musnah;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $bilangan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $bilangan_rosak;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_mangsa_pertanian;

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
     * @var string
     */
    private $nama_bencana;

        /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_agensi;

        /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_jenis_pertanian;

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
     * @var integer
     */
    private $anggaran_nilai_rosak;

      /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $anggaran_nilai_bantuan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $kos_bantuan;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_bantuan;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $catatan;
}
