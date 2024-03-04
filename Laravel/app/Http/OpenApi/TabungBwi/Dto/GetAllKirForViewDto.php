<?php

namespace app\Http\OpenApi;

/**
 * Class GetAllKirForViewDto
 *
 * @OA\Schema(
 *     title="GetAllKirForViewDto Schema"
 * )
 */
class GetAllKirForViewDto
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
    private $nama;

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
    private $id_daerah;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_negeri;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_daerah;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $isi_rumah;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $jumlah_bwi;

}
