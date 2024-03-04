<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefDaerahDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefDaerahDto Schema"
 * )
 */
class CreateOrEditRefDaerahDto
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
     * @var string
     */
    private $nama_daerah;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_daerah;
    
}
