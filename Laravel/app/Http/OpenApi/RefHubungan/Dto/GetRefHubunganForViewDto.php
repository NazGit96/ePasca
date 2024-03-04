<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefHubunganForViewDto
 *
 * @OA\Schema(
 *     title="GetRefHubunganForViewDto Schema"
 * )
 */
class GetRefHubunganForViewDto
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
    private $nama_hubungan;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_hubungan;
    
}
