<?php

namespace app\Http\OpenApi;

/**
 * Class RefStatusKerosakanDto
 *
 * @OA\Schema(
 *     title="RefStatusKerosakanDto Schema"
 * )
 */
class RefStatusKerosakanDto
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
