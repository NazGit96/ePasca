<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefJenisPertanianForViewDto
 *
 * @OA\Schema(
 *     title="GetRefJenisPertanianForViewDto Schema"
 * )
 */
class GetRefJenisPertanianForViewDto
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
