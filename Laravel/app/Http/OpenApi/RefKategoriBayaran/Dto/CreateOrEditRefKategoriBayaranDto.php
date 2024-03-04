<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefKategoriBayaranDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefKategoriBayaranDto Schema"
 * )
 */
class CreateOrEditRefKategoriBayaranDto
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
