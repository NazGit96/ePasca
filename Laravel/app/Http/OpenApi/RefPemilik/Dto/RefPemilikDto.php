<?php

namespace app\Http\OpenApi;

/**
 * Class RefPemilikDto
 *
 * @OA\Schema(
 *     title="RefPemilikDto Schema"
 * )
 */
class RefPemilikDto
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
    private $nama_pemilik;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_pemilik;
    
}
