<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefJenisBayaranDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefJenisBayaranDto Schema"
 * )
 */
class CreateOrEditRefJenisBayaranDto
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
    private $nama_jenis_bayaran;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_jenis_bayaran;
    
}
