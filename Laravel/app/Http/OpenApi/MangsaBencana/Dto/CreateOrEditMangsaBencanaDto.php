<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditMangsaBencanaDto
 *
 * @OA\Schema(
 *     title="CreateOrEditMangsaBencanaDto Schema"
 * )
 */
class CreateOrEditMangsaBencanaDto
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
    private $id_pindah;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_pusat_pemindahan;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $masalah;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_mangsa_bencana;

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
    private $id_agensi;

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
