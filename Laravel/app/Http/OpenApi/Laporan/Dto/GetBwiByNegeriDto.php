<?php

namespace app\Http\OpenApi;

/**
 * Class GetBwiByNegeriDto
 *
 * @OA\Schema(
 *     title="GetBwiByNegeriDto Schema"
 * )
 */
class GetBwiByNegeriDto
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
     * @var integer
     */
    private $bil;

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
    private $tarikh_cipta;

}
