<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefNegeriDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefNegeriDto Schema"
 * )
 */
class CreateOrEditRefNegeriDto
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
    private $nama_negeri;
    
    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $kod_negeri;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_negeri;
    
}
