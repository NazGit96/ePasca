<?php

namespace app\Http\OpenApi;

/**
 * Class GetLaporanBwiBencanaKirDto
 *
 * @OA\Schema(
 *     title="GetLaporanBwiBencanaKirDto Schema"
 * )
 */
class GetLaporanBwiBencanaKirDto
{
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
    private $nama_bencana;

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
     * @var integer
     */
    private $bil;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_peruntukan;

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
    private $jumlah_diagihkan;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_bencana;

}
