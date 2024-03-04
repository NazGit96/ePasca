<?php

namespace app\Http\OpenApi;

/**
 * Class GetLaporanBayaranTerusDto
 *
 * @OA\Schema(
 *     title="GetLaporanBayaranTerusDto Schema"
 * )
 */
class GetLaporanBayaranTerusDto
{
    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $no_rujukan_terus;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $no_rujukan_kelulusan;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $no_baucar;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $perihal;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $penerima;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_kategori_bayaran;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_kategori_bayaran;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah;

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
     * )
     *
     * @var string
     */
    private $nama_tabung;

}
