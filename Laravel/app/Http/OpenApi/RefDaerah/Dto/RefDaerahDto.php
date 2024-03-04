<?php

namespace app\Http\OpenApi;

/**
 * Class RefDaerahDto
 *
 * @OA\Schema(
 *     title="RefDaerahDto Schema"
 * )
 */
class RefDaerahDto
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
     * @var integer
     */
    private $id_negeri;
    
    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_daerah;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_daerah;
    
}
