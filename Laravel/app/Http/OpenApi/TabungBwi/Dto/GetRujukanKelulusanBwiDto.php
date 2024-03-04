<?php

namespace app\Http\OpenApi;

/**
 * Class GetRujukanKelulusanBwiDto
 *
 * @OA\Schema(
 *     title="GetRujukanKelulusanBwiDto Schema"
 * )
 */
class GetRujukanKelulusanBwiDto
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

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_bencana;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $rujukan_surat;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $perihal_surat;

}
