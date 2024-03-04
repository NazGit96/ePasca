<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungByYearDto
 *
 * @OA\Schema(
 *     title="GetTabungByYearDto Schema"
 * )
 */
class GetTabungByYearDto
{

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $dana_tambahan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $baki_bawaan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_kelulusan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $peruntukan_diambil;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_tanggungan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_belanja;
}
