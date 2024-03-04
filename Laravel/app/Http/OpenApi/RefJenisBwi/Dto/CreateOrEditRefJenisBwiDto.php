<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefJenisBwiDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefJenisBwiDto Schema"
 * )
 */
class CreateOrEditRefJenisBwiDto
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
    private $nama_jenis_bwi;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_jenis_bwi;
    
}
