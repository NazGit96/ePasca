<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefPelaksanaForViewDto
 *
 * @OA\Schema(
 *     title="GetRefPelaksanaForViewDto Schema"
 * )
 */
class GetRefPelaksanaForViewDto
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
