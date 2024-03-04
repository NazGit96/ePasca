<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefStatusKerosakanDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefStatusKerosakanDto Schema"
 * )
 */
class CreateOrEditRefStatusKerosakanDto
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
    private $nama_status_kerosakan;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status;
    
}
