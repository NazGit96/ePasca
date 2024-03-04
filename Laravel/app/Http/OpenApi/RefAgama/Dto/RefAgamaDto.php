<?php

namespace app\Http\OpenApi;

/**
 * Class RefAgamaDto
 *
 * @OA\Schema(
 *     title="RefAgamaDto Schema"
 * )
 */
class RefAgamaDto
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
    private $nama_agama;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_agama;
    
}
