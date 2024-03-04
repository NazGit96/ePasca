<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefJenisPeruntukanForViewDto
 *
 * @OA\Schema(
 *     title="GetRefJenisPeruntukanForViewDto Schema"
 * )
 */
class GetRefJenisPeruntukanForViewDto
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
