<?php

namespace app\Http\OpenApi;

/**
 * Class RefPinjamanPerniagaanDto
 *
 * @OA\Schema(
 *     title="RefPinjamanPerniagaanDto Schema"
 * )
 */
class RefPinjamanPerniagaanDto
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
    private $nama_agensi_pinjaman;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_agensi_pinjaman;
    
}
