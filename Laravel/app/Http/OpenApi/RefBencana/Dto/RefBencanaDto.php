<?php

namespace app\Http\OpenApi;

/**
 * Class RefBencanaDto
 *
 * @OA\Schema(
 *     title="RefBencanaDto Schema"
 * )
 */
class RefBencanaDto
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
     *     format="date",
     * )
     *
     * @var string
     */
    private $tarikh_bencana;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $tahun_bencana;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_jenis_bencana;
    
    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_bencana;
    
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
    private $catatan;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_bencana;
    
}
