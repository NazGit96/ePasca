<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefPemilikForViewDto
 *
 * @OA\Schema(
 *     title="GetRefPemilikForViewDto Schema"
 * )
 */
class GetRefPemilikForViewDto
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
