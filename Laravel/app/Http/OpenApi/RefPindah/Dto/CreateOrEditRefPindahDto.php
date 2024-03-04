<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefPindahDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefPindahDto Schema"
 * )
 */
class CreateOrEditRefPindahDto
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
    private $pindah;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_pindah;
    
}
