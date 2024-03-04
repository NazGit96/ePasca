<?php

namespace app\Http\OpenApi;

/**
 * Class RefTapakRumahDto
 *
 * @OA\Schema(
 *     title="RefTapakRumahDto Schema"
 * )
 */
class RefTapakRumahDto
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
    private $nama_tapak_rumah;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_tapak_rumah;
    
}
