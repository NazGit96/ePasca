<?php

namespace app\Http\OpenApi;

/**
 * Class RefJenisBwiDto
 *
 * @OA\Schema(
 *     title="RefJenisBwiDto Schema"
 * )
 */
class RefJenisBwiDto
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
