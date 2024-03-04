<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefSumberDanaForViewDto
 *
 * @OA\Schema(
 *     title="GetRefSumberDanaForViewDto Schema"
 * )
 */
class GetRefSumberDanaForViewDto
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
    private $nama_sumber_dana;
    
    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $ringkasan_sumber_dana;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_sumber_dana;
    
}
