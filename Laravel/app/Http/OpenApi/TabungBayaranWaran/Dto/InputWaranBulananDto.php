<?php

namespace app\Http\OpenApi;

/**
 * Class InputWaranBulananDto
 *
 * @OA\Schema(
 *     title="InputWaranBulananDto Schema"
 * )
 */
class InputWaranBulananDto
{

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $bulan;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $tahun;

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
    private $id_bulan;

}
