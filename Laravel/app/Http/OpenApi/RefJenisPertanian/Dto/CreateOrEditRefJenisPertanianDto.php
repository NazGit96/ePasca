<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefJenisPertanianDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefJenisPertanianDto Schema"
 * )
 */
class CreateOrEditRefJenisPertanianDto
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
