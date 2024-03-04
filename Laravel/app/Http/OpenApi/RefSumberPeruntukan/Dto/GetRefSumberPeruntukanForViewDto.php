<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefSumberPeruntukanForViewDto
 *
 * @OA\Schema(
 *     title="GetRefSumberPeruntukanForViewDto Schema"
 * )
 */
class GetRefSumberPeruntukanForViewDto
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
    private $nama_sumber_peruntukan;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_sumber_peruntukan;
    
}
