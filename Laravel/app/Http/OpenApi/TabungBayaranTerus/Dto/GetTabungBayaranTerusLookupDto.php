<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungBayaranTerusLookupDto
 *
 * @OA\Schema(
 *     title="GetTabungBayaranTerusLookupDto Schema"
 * )
 */
class GetTabungBayaranTerusLookupDto
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
    private $no_rujukan_terus;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $perihal;

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
     * @var integer
     */
    private $id_tabung_kelulusan;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $no_rujukan_kelulusan;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_bencana;

}
