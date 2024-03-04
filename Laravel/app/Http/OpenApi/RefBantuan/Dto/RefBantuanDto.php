<?php

namespace app\Http\OpenApi;

/**
 * Class RefBantuanDto
 *
 * @OA\Schema(
 *     title="RefBantuanDto Schema"
 * )
 */
class RefBantuanDto
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
