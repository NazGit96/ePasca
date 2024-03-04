<?php

namespace app\Http\OpenApi;

/**
 * Class GetLaporanWaranDto
 *
 * @OA\Schema(
 *     title="GetLaporanWaranDto Schema"
 * )
 */
class GetLaporanWaranDto
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
    private $no_rujukan_waran;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $no_rujukan_kelulusan;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_surat_waran;

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
     * @var string
     */
    private $nama_waran_status;


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
    private $nama_agensi;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_siling_peruntukan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_baki_peruntukan;

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
     * @var string
     */
    private $rujukan_surat_waran;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_januari;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_februari;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_mac;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_april;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_mei;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_jun;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_julai;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_ogos;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_september;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_oktober;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_november;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_disember;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_keseluruhan;
}
