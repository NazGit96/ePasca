<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefPemilikDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefPemilikDto Schema"
 * )
 */
class CreateOrEditRefPemilikDto
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
