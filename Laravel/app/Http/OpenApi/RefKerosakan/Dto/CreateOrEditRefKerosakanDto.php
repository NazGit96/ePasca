<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefKerosakanDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefKerosakanDto Schema"
 * )
 */
class CreateOrEditRefKerosakanDto
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
    private $nama_kerosakan;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_kerosakan;
    
}
