<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefPindahForViewDto
 *
 * @OA\Schema(
 *     title="GetRefPindahForViewDto Schema"
 * )
 */
class GetRefPindahForViewDto
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
