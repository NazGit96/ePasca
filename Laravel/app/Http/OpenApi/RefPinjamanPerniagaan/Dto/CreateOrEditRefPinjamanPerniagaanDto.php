<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefPinjamanPerniagaanDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefPinjamanPerniagaanDto Schema"
 * )
 */
class CreateOrEditRefPinjamanPerniagaanDto
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
