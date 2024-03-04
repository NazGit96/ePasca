<?php

namespace app\Http\OpenApi;

/**
 * Class RefKementerianDto
 *
 * @OA\Schema(
 *     title="RefKementerianDto Schema"
 * )
 */
class RefKementerianDto
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
    private $nama_kementerian;
    
    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $kod_kementerian;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_kementerian;
    
}
