<?php

namespace app\Http\OpenApi;

/**
 * Class InputSkbBulananDto
 *
 * @OA\Schema(
 *     title="InputSkbBulananDto Schema"
 * )
 */
class InputSkbBulananDto
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
