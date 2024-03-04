<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefJenisBencanaDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefJenisBencanaDto Schema"
 * )
 */
class CreateOrEditRefJenisBencanaDto
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
