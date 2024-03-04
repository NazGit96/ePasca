<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungKelulusanForViewDto
 *
 * @OA\Schema(
 *     title="GetTabungKelulusanForViewDto Schema"
 * )
 */
class GetTabungKelulusanForViewDto
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
    private $no_rujukan_kelulusan;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $id_tabung;

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
    private $rujukan_surat;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_surat;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $jumlah_siling;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $baki_jumlah_siling;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_tabung_kelulusan;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_mula_kelulusan;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_tamat_kelulusan;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $peruntukan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_tabung;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $perihal_surat;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_dipulangkan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $kategori_tabung;

}
