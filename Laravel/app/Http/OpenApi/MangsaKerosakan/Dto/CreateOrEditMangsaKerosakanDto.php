<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditMangsaKerosakanDto
 *
 * @OA\Schema(
 *     title="CreateOrEditMangsaKerosakanDto Schema"
 * )
 */
class CreateOrEditMangsaKerosakanDto
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
    private $id_mangsa;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_mangsa_rumah;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_kerosakan;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_kerosakan;
    
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
    private $tarikh_cipta;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_agensi;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_pengguna_kemaskini;
    
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
     * @var string
     */
    private $sebab_hapus;
    
}
