<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungBayaranWaranForViewDto
 *
 * @OA\Schema(
 *     title="GetTabungBayaranWaranForViewDto Schema"
 * )
 */
class GetTabungBayaranWaranForViewDto
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
    private $jumlah_siling_peruntukan;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $jumlah_baki_peruntukan;

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
    private $nama_tabung;

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
     * @var integer
     */
    private $id_jenis_bayaran;

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
    private $nama_jenis_bayaran;

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
    private $nama_waran_status;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_belanja;

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
     * @var string
     */
    private $perihal;
}
