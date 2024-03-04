<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditTabungKelulusanAmbilanDto
 *
 * @OA\Schema(
 *     title="CreateOrEditTabungKelulusanAmbilanDto Schema"
 * )
 */
class CreateOrEditTabungKelulusanAmbilanDto
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
    private $id_tabung_kelulusan;

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
     * @var integer
     */
    private $jenis_transaksi;

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
    private $catatan;

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

}
