<?php

namespace app\Http\OpenApi;

/**
 * Class GetRingkasanLaporanBwiByNegeriDto
 *
 * @OA\Schema(
 *     title="GetRingkasanLaporanBwiByNegeriDto Schema"
 * )
 */
class GetRingkasanLaporanBwiByNegeriDto
{
    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $kategori;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_diagihkan;

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
    private $bil;

}
