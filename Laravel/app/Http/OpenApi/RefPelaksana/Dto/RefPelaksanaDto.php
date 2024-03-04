<?php

namespace app\Http\OpenApi;

/**
 * Class RefPelaksanaDto
 *
 * @OA\Schema(
 *     title="RefPelaksanaDto Schema"
 * )
 */
class RefPelaksanaDto
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
    private $nama_pelaksana;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_pelaksana;
    
}
