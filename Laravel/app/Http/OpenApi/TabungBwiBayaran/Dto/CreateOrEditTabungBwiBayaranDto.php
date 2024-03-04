<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditTabungBwiBayaranDto
 *
 * @OA\Schema(
 *     title="CreateOrEditTabungBwiBayaranDto Schema"
 * )
 */
class CreateOrEditTabungBwiBayaranDto
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
    private $id_tabung_bwi;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_tabung_bayaran_skb;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_tabung_bayaran_terus;
    
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
     * )
     *
     * @var boolean
     */
    private $hapus;
    
    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_hapus;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_pengguna_hapus;
    
}
