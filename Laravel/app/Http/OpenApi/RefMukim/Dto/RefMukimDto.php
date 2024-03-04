<?php

namespace app\Http\OpenApi;

/**
 * Class RefMukimDto
 *
 * @OA\Schema(
 *     title="RefMukimDto Schema"
 * )
 */
class RefMukimDto
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
