<?php

namespace app\Http\OpenApi;

/**
 * Class RefJenisPeruntukanDto
 *
 * @OA\Schema(
 *     title="RefJenisPeruntukanDto Schema"
 * )
 */
class RefJenisPeruntukanDto
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
    private $nama_jenis_peruntukan;
    
}
