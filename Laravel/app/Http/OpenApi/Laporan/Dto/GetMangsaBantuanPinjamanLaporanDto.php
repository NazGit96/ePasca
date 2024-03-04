<?php

namespace app\Http\OpenApi;

/**
 * Class GetMangsaBantuanPinjamanLaporanDto
 *
 * @OA\Schema(
 *     title="GetMangsaBantuanPinjamanLaporanDto Schema"
 * )
 */
class GetMangsaBantuanPinjamanLaporanDto
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
    private $sektor;

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
    private $tempoh_pinjaman;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $jumlah_pinjaman;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_cipta;

}
