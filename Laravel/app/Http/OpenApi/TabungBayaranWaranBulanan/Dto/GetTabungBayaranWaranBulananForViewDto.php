<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungBayaranWaranBulananForViewDto
 *
 * @OA\Schema(
 *     title="GetTabungBayaranWaranBulananForViewDto Schema"
 * )
 */
class GetTabungBayaranWaranBulananForViewDto
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
    private $id_tabung_bayaran_waran;

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
