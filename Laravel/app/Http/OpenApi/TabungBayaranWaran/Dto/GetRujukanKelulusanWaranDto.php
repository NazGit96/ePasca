<?php

namespace app\Http\OpenApi;

/**
 * Class GetRujukanKelulusanWaranDto
 *
 * @OA\Schema(
 *     title="GetRujukanKelulusanWaranDto Schema"
 * )
 */
class GetRujukanKelulusanWaranDto
{

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $no_rujukan_kelulusan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_tabung;

}
