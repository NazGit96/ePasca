<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefDunDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefDunDto Schema"
 * )
 */
class CreateOrEditRefDunDto
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
    private $id_parlimen;
    
    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $kod_dun;
    
    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_dun;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_dun;
    
}
