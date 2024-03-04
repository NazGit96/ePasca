<?php

namespace app\Http\OpenApi;

/**
 * Class GetWaranByIdKelulusanDto
 *
 * @OA\Schema(
 *     title="GetWaranByIdKelulusanDto Schema"
 * )
 */
class GetWaranByIdKelulusanDto
{

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $no_rujukan_waran;

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
    private $jumlah_siling_peruntukan;
}
