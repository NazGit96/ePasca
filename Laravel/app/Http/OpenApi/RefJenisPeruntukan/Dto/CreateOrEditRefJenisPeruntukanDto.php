<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefJenisPeruntukanDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefJenisPeruntukanDto Schema"
 * )
 */
class CreateOrEditRefJenisPeruntukanDto
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
