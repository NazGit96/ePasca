<?php

namespace app\Http\OpenApi;

/**
 * Class GetMangsaBantuanAntarabangsaLaporanDto
 *
 * @OA\Schema(
 *     title="GetMangsaBantuanAntarabangsaLaporanDto Schema"
 * )
 */
class GetMangsaBantuanAntarabangsaLaporanDto
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
    private $nama_bantuan;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $negara;

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
    private $kos_bantuan;

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
    private $tarikh_cipta;

}
