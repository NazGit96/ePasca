<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefPinjamanPerniagaanForViewDto
 *
 * @OA\Schema(
 *     title="GetRefPinjamanPerniagaanForViewDto Schema"
 * )
 */
class GetRefPinjamanPerniagaanForViewDto
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
