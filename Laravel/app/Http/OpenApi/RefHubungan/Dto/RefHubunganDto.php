<?php

namespace app\Http\OpenApi;

/**
 * Class RefHubunganDto
 *
 * @OA\Schema(
 *     title="RefHubunganDto Schema"
 * )
 */
class RefHubunganDto
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
    private $nama_hubungan;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_hubungan;
    
}
