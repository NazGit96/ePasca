<?php

namespace app\Http\OpenApi;

/**
 * Class InputBwiBayaranDto
 *
 * @OA\Schema(
 *     title="InputBwiBayaranDto Schema"
 * )
 */
class InputBwiBayaranDto
{

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_skb;

     /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_terus;
}
