<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefAgamaForViewDto
 *
 * @OA\Schema(
 *     title="GetRefAgamaForViewDto Schema"
 * )
 */
class GetRefAgamaForViewDto
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
    private $nama_agama;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_agama;
    
}
