<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefKategoriBayaranForViewDto
 *
 * @OA\Schema(
 *     title="GetRefKategoriBayaranForViewDto Schema"
 * )
 */
class GetRefKategoriBayaranForViewDto
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
