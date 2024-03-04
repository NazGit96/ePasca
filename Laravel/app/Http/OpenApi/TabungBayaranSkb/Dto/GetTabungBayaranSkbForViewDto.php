<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungBayaranSkbForViewDto
 *
 * @OA\Schema(
 *     title="GetTabungBayaranSkbForViewDto Schema"
 * )
 */
class GetTabungBayaranSkbForViewDto
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
    private $no_rujukan_skb;

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
    private $nama_pegawai;

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
    private $tarikh_tamat;

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
     * @var integer
     */
    private $id_tabung_kelulusan;

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
    private $nama_skb_status;

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
    private $nama_bencana;
}
