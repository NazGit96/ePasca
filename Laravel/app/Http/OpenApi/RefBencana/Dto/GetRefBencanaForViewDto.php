<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefBencanaForViewDto
 *
 * @OA\Schema(
 *     title="GetRefBencanaForViewDto Schema"
 * )
 */
class GetRefBencanaForViewDto
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
    private $no_rujukan_bencana;

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

    /**
    * @OA\Property(
    * )
    *
    * @var string
    */
    private $nama_jenis_bencana;

}
