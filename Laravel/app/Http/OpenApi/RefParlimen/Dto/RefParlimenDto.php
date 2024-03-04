<?php

namespace app\Http\OpenApi;

/**
 * Class RefParlimenDto
 *
 * @OA\Schema(
 *     title="RefParlimenDto Schema"
 * )
 */
class RefParlimenDto
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
    private $nama_parlimen;
    
    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $kod_parlimen;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_parlimen;
    
}
