<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefJenisBencanaForViewDto
 *
 * @OA\Schema(
 *     title="GetRefJenisBencanaForViewDto Schema"
 * )
 */
class GetRefJenisBencanaForViewDto
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
    private $nama_jenis_bencana;
    
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
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_pengguna;
    
}
