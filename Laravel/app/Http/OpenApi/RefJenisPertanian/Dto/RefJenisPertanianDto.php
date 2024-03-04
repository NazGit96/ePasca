<?php

namespace app\Http\OpenApi;

/**
 * Class RefJenisPertanianDto
 *
 * @OA\Schema(
 *     title="RefJenisPertanianDto Schema"
 * )
 */
class RefJenisPertanianDto
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
    private $nama_jenis_pertanian;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_jenis_pertanian;
    
}
