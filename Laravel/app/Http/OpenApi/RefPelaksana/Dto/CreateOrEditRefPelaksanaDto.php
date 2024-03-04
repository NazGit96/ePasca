<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefPelaksanaDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefPelaksanaDto Schema"
 * )
 */
class CreateOrEditRefPelaksanaDto
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
    private $nama_pelaksana;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_pelaksana;
    
}
