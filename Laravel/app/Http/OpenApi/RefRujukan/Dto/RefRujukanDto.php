<?php

namespace app\Http\OpenApi;

/**
 * Class RefRujukanDto
 *
 * @OA\Schema(
 *     title="RefRujukanDto Schema"
 * )
 */
class RefRujukanDto
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
    private $nama_rujukan;
    
    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_dokumen;
    
    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $lokasi_dokumen;
    
    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $sambungan_fail;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_rujukan;
    
    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_cipta;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_pengguna_cipta;
    
    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_kemaskini;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_pengguna_kemaskini;
    
}
