<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefStatusKerosakanForViewDto
 *
 * @OA\Schema(
 *     title="GetRefStatusKerosakanForViewDto Schema"
 * )
 */
class GetRefStatusKerosakanForViewDto
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
