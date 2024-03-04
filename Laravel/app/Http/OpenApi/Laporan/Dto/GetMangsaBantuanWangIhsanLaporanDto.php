<?php

namespace app\Http\OpenApi;

/**
 * Class GetMangsaBantuanWangIhsanLaporanDto
 *
 * @OA\Schema(
 *     title="GetMangsaBantuanWangIhsanLaporanDto Schema"
 * )
 */
class GetMangsaBantuanWangIhsanLaporanDto
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
    private $nama_bencana;

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
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_serahan;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $jumlah;

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
    private $nama_jenis_bwi;
}
