<?php

namespace app\Http\OpenApi;

/**
 * Class GetKelulusanByKategoriBayaranDto
 *
 * @OA\Schema(
 *     title="GetKelulusanByKategoriBayaranDto Schema"
 * )
 */
class GetKelulusanByKategoriBayaranDto
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
    private $jumlah;

}
