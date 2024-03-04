<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefJenisBwiForViewDto
 *
 * @OA\Schema(
 *     title="GetRefJenisBwiForViewDto Schema"
 * )
 */
class GetRefJenisBwiForViewDto
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
    private $nama_jenis_bwi;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_jenis_bwi;
    
}
