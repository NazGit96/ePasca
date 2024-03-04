<?php

namespace app\Http\OpenApi;

/**
 * Class GetLaporanBwiKematianDto
 *
 * @OA\Schema(
 *     title="GetLaporanBwiKematianDto Schema"
 * )
 */
class GetLaporanBwiKematianDto
{
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
    private $no_rujukan_saluran_kpd_bkp;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_saluran_kpd_bkp;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $catatan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $bil_kir;


    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_cipta;

}
