<?php

namespace app\Http\OpenApi;

/**
 * Class GetRujukanKelulusanSkbDto
 *
 * @OA\Schema(
 *     title="GetRujukanKelulusanSkbDto Schema"
 * )
 */
class GetRujukanKelulusanSkbDto
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
