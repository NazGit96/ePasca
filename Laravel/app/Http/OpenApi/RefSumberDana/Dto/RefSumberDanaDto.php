<?php

namespace app\Http\OpenApi;

/**
 * Class RefSumberDanaDto
 *
 * @OA\Schema(
 *     title="RefSumberDanaDto Schema"
 * )
 */
class RefSumberDanaDto
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
    private $nama_sumber_dana;
    
    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $ringkasan_sumber_dana;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_sumber_dana;
    
}
