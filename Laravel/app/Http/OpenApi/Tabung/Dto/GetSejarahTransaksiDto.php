<?php

namespace app\Http\OpenApi;

/**
 * Class GetSejarahTransaksiDto
 *
 * @OA\Schema(
 *     title="GetSejarahTransaksiDto Schema"
 * )
 */
class GetSejarahTransaksiDto
{

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $no_ruj;

     /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $aktiviti;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama;

}
