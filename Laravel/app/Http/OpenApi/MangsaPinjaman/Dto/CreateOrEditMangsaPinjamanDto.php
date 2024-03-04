<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditMangsaPinjamanDto
 *
 * @OA\Schema(
 *     title="CreateOrEditMangsaPinjamanDto Schema"
 * )
 */
class CreateOrEditMangsaPinjamanDto
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
    private $id_sektor;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $sektor;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_pinjaman;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $tempoh_pinjaman;

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
     * @var integer
     */
    private $id_agensi_bantuan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_mangsa_pinjaman;

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
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_mula;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_bencana;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_bencana;
}
