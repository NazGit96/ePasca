<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefAgamaDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefAgamaDto Schema"
 * )
 */
class CreateOrEditRefAgamaDto
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
    private $nama_agama;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_agama;
    
}
