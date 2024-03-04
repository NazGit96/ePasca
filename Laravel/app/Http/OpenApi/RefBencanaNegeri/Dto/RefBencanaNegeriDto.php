<?php

namespace app\Http\OpenApi;

/**
 * Class RefBencanaNegeriDto
 *
 * @OA\Schema(
 *     title="RefBencanaNegeriDto Schema"
 * )
 */
class RefBencanaNegeriDto
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
    private $id_bencana;
    
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
     * @var integer
     */
    private $status_bencana_negeri;
    
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
