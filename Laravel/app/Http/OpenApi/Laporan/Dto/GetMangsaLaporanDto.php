<?php

namespace app\Http\OpenApi;

/**
 * Class GetMangsaLaporanDto
 *
 * @OA\Schema(
 *     title="GetMangsaLaporanDto Schema"
 * )
 */
class GetMangsaLaporanDto
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
     * @var string
     */
    private $alamat_1;


    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $alamat_2;

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
    private $nama_agensi;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_kementerian;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_cipta;

}
