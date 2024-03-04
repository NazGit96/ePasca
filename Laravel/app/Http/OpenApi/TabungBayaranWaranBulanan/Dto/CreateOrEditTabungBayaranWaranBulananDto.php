<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditTabungBayaranWaranBulananDto
 *
 * @OA\Schema(
 *     title="CreateOrEditTabungBayaranWaranBulananDto Schema"
 * )
 */
class CreateOrEditTabungBayaranWaranBulananDto
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
     * @var integer
     */
    private $id_tabung;

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
     * @var integer
     */
    private $tahun;

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
    private $jumlah_lama;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_pengguna_cipta;

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
    private $id_pengguna_kemaskini;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_kemaskini;

}
