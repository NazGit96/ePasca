<?php

namespace app\Http\OpenApi;

/**
 * Class RefSumberPeruntukanDto
 *
 * @OA\Schema(
 *     title="RefSumberPeruntukanDto Schema"
 * )
 */
class RefSumberPeruntukanDto
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
