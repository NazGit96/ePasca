<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungBwiBayaranForViewDto
 *
 * @OA\Schema(
 *     title="GetTabungBwiBayaranForViewDto Schema"
 * )
 */
class GetTabungBwiBayaranForViewDto
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
    private $id_tabung_bwi;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_tabung_bayaran;

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
     * @var integer
     */
    private $id_tabung_bayaran_terus;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_cipta;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_pengguna_cipta;

    /**
     * @OA\Property(
     * )
     *
     * @var boolean
     */
    private $hapus;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_hapus;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_pengguna_hapus;

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
     * @var integer
     */
    private $id_bayaran_skb;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_bayaran_terus;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $no_rujukan_bayaran;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $no_rujukan_terus;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $no_rujukan_skb;

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
     * @var integer
     */
    private $jumlah;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $perihal;
}
