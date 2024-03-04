<?php

namespace app\Http\OpenApi;

/**
 * Class GetBayaranTerusByIdKelulusanDto
 *
 * @OA\Schema(
 *     title="GetBayaranTerusByIdKelulusanDto Schema"
 * )
 */
class GetBayaranTerusByIdKelulusanDto
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
    private $no_rujukan_terus;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah;

}
