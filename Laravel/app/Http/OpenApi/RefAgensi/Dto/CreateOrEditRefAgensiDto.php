<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefAgensiDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefAgensiDto Schema"
 * )
 */
class CreateOrEditRefAgensiDto
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
    private $id_kementerian;
    
    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_agensi;
    
    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $kod_agensi;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $pemberi_bantuan;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $pemberi_pinjaman;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $pengguna_sistem;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_agensi;
    
}
