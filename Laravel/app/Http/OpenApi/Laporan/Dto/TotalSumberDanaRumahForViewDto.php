<?php

namespace app\Http\OpenApi;

/**
 * Class TotalSumberDanaRumahForViewDto
 *
 * @OA\Schema(
 *     title="TotalSumberDanaRumahForViewDto Schema"
 * )
 */
class TotalSumberDanaRumahForViewDto
{

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_sumber_dana;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah;
}
