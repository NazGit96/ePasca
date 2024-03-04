<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefTapakRumahDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefTapakRumahDto Schema"
 * )
 */
class CreateOrEditRefTapakRumahDto
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
