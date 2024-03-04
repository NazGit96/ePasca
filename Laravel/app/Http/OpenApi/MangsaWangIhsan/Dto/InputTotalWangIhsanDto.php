<?php

namespace app\Http\OpenApi;

/**
 * Class InputTotalWangIhsanDto
 *
 * @OA\Schema(
 *     title="InputTotalWangIhsanDto Schema"
 * )
 */
class InputTotalWangIhsanDto
{

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_belum_dibayar;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $bil_belum_dibayar;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_dibayar;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $bil_dibayar;

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
    private $bil_dipulangkan;

}
