<?php

namespace app\Http\OpenApi;

/**
 * Class GetSkbByIdKelulusanDto
 *
 * @OA\Schema(
 *     title="GetSkbByIdKelulusanDto Schema"
 * )
 */
class GetSkbByIdKelulusanDto
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
    private $no_rujukan_skb;

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
