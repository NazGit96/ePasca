<?php

namespace app\Http\OpenApi;

/**
 * Class RefKerosakanDto
 *
 * @OA\Schema(
 *     title="RefKerosakanDto Schema"
 * )
 */
class RefKerosakanDto
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
