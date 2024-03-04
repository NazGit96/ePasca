<?php

namespace app\Http\OpenApi;

/**
 * Class RefKategoriBayaranDto
 *
 * @OA\Schema(
 *     title="RefKategoriBayaranDto Schema"
 * )
 */
class RefKategoriBayaranDto
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
    private $nama_kategori_bayaran;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_kategori_bayaran;
    
}
