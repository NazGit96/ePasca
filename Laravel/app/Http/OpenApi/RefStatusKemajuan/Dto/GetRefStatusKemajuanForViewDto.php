<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefStatusKemajuanForViewDto
 *
 * @OA\Schema(
 *     title="GetRefStatusKemajuanForViewDto Schema"
 * )
 */
class GetRefStatusKemajuanForViewDto
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
    private $status_kemajuan;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status;
    
    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $kod_status_kemajuan;
    
}
