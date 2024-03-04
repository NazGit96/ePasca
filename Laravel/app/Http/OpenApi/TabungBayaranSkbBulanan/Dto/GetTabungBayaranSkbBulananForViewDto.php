<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungBayaranSkbBulananForViewDto
 *
 * @OA\Schema(
 *     title="GetTabungBayaranSkbBulananForViewDto Schema"
 * )
 */
class GetTabungBayaranSkbBulananForViewDto
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
    private $id_tabung_bayaran_skb;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $bulan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_bulan;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $tahun;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $jumlah;

}
