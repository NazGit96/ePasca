<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefJenisBayaranForViewDto
 *
 * @OA\Schema(
 *     title="GetRefJenisBayaranForViewDto Schema"
 * )
 */
class GetRefJenisBayaranForViewDto
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
    private $nama_jenis_bayaran;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_jenis_bayaran;
    
}
