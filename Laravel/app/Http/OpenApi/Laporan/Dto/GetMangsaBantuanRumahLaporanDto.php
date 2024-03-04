<?php

namespace app\Http\OpenApi;

/**
 * Class GetMangsaBantuanRumahLaporanDto
 *
 * @OA\Schema(
 *     title="GetMangsaBantuanRumahLaporanDto Schema"
 * )
 */
class GetMangsaBantuanRumahLaporanDto
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
    private $nama_pemilik;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_sumber_dana;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_pelaksana;

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
    private $peratus_kemajuan;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $status_kemajuan;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $kos_anggaran;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $kos_sebenar;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_cipta;

}
