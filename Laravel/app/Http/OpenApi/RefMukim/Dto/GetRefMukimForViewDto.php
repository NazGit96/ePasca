<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefMukimForViewDto
 *
 * @OA\Schema(
 *     title="GetRefMukimForViewDto Schema"
 * )
 */
class GetRefMukimForViewDto
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
