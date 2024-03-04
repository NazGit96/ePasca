<?php

namespace app\Http\OpenApi;

/**
 * Class RefPindahDto
 *
 * @OA\Schema(
 *     title="RefPindahDto Schema"
 * )
 */
class RefPindahDto
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
    private $pindah;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_pindah;
    
}
