<?php

namespace app\Http\OpenApi;

/**
 * Class UpdateBwiBayaranDto
 *
 * @OA\Schema(
 *     title="UpdateBwiBayaranDto Schema"
 * )
 */
class UpdateBwiBayaranDto
{
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_temp;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_tabung_bayaran_skb;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_tabung_bayaran_terus;

}
