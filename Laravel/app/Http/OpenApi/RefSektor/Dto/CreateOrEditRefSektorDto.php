<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefSektorDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefSektorDto Schema"
 * )
 */
class CreateOrEditRefSektorDto
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
    private $nama_sektor;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_sektor;
    
}
