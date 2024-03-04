<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefWarganegaraForViewDto
 *
 * @OA\Schema(
 *     title="GetRefWarganegaraForViewDto Schema"
 * )
 */
class GetRefWarganegaraForViewDto
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
    private $kod_warganegara;
    
    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_warganegara;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_warganegara;
    
}
