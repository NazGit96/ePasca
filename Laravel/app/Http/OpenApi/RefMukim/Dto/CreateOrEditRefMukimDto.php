<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefMukimDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefMukimDto Schema"
 * )
 */
class CreateOrEditRefMukimDto
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
     * @var integer
     */
    private $id_negeri;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_daerah;
    
    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_mukim;
    
}
