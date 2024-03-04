<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefKerosakanForViewDto
 *
 * @OA\Schema(
 *     title="GetRefKerosakanForViewDto Schema"
 * )
 */
class GetRefKerosakanForViewDto
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
