<?php

namespace app\Http\OpenApi;

/**
 * Class RefJenisBayaranDto
 *
 * @OA\Schema(
 *     title="RefJenisBayaranDto Schema"
 * )
 */
class RefJenisBayaranDto
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
