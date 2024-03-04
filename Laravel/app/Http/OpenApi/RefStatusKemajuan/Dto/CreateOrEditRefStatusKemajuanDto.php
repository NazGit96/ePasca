<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefStatusKemajuanDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefStatusKemajuanDto Schema"
 * )
 */
class CreateOrEditRefStatusKemajuanDto
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
