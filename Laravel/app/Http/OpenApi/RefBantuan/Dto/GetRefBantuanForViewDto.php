<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefBantuanForViewDto
 *
 * @OA\Schema(
 *     title="GetRefBantuanForViewDto Schema"
 * )
 */
class GetRefBantuanForViewDto
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
    private $nama_bantuan;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_bantuan;
    
}
