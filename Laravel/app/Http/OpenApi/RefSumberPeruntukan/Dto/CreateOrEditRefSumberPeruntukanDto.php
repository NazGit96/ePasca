<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefSumberPeruntukanDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefSumberPeruntukanDto Schema"
 * )
 */
class CreateOrEditRefSumberPeruntukanDto
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
    private $nama_sumber_peruntukan;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_sumber_peruntukan;
    
}
