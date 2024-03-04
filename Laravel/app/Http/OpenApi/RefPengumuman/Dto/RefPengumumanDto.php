<?php

namespace app\Http\OpenApi;

/**
 * Class RefPengumumanDto
 *
 * @OA\Schema(
 *     title="RefPengumumanDto Schema"
 * )
 */
class RefPengumumanDto
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
    private $nama_pengumuman;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_pengumuman;

}
