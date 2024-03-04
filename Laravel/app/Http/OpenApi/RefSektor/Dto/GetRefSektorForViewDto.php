<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefSektorForViewDto
 *
 * @OA\Schema(
 *     title="GetRefSektorForViewDto Schema"
 * )
 */
class GetRefSektorForViewDto
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
    private $nama_sektor;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_sektor;
    
}
