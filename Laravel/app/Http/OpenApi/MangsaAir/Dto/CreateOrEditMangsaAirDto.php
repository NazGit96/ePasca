<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditMangsaAirDto
 *
 * @OA\Schema(
 *     title="CreateOrEditMangsaAirDto Schema"
 * )
 */
class CreateOrEditMangsaAirDto
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
    private $id_mangsa;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $no_kp;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_hubungan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $umur;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $pekerjaan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_mangsa_air;

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
    private $sebab_hapus;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_lahir;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_umur;

}
