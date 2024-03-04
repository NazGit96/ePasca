<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungBwiForViewDto
 *
 * @OA\Schema(
 *     title="GetTabungBwiForViewDto Schema"
 * )
 */
class GetTabungBwiForViewDto
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
    private $no_rujukan_bwi;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_jenis_bwi;

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
     * @var string
     */
    private $nama_kejadian;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_kejadian;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_jenis_bwi;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_bencana;

     /**
     * @OA\Property(
     *     format="date-time",
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
    private $jumlah_negeri;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_bayaran_bwi;
}
