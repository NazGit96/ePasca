<?php

namespace app\Http\OpenApi;

/**
 * Class RefSektorDto
 *
 * @OA\Schema(
 *     title="RefSektorDto Schema"
 * )
 */
class RefSektorDto
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
    private $nama_sektor;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_sektor;
    
}
