<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditTabungBayaranSkbDto
 *
 * @OA\Schema(
 *     title="CreateOrEditTabungBayaranSkbDto Schema"
 * )
 */
class CreateOrEditTabungBayaranSkbDto
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
    private $rujukan_surat_skb;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_surat_skb;

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
    private $nama_pegawai;

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
     * @var string
     */
    private $perihal;

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
     * @var boolean
     */
    private $hapus;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_pengguna_hapus;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_hapus;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $sebab_hapus;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_tabung;

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
     * @var integer
     */
    private $id_tabung_bayaran_skb_status;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_bencana;

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
    private $nama_tabung;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_bencana;

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
    private $id_status_skb;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $catatan;

}
