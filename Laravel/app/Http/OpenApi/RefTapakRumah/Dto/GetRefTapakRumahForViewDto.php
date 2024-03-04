<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefTapakRumahForViewDto
 *
 * @OA\Schema(
 *     title="GetRefTapakRumahForViewDto Schema"
 * )
 */
class GetRefTapakRumahForViewDto
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
