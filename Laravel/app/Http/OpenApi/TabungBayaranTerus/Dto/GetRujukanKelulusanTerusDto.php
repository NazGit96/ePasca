<?php

namespace app\Http\OpenApi;

/**
 * Class GetRujukanKelulusanTerusDto
 *
 * @OA\Schema(
 *     title="GetRujukanKelulusanTerusDto Schema"
 * )
 */
class GetRujukanKelulusanTerusDto
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
