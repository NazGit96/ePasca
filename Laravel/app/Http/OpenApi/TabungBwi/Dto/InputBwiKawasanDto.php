<?php

namespace app\Http\OpenApi;

/**
 * Class InputBwiKawasanDto
 *
 * @OA\Schema(
 *     title="InputBwiKawasanDto Schema"
 * )
 */
class InputBwiKawasanDto
{

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_daerah;

     /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_negeri;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_bwi;
}
