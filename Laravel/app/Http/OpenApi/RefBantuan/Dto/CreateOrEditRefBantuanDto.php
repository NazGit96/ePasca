<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefBantuanDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefBantuanDto Schema"
 * )
 */
class CreateOrEditRefBantuanDto
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
