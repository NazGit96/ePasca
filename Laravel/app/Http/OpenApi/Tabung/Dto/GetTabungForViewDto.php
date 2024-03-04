<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungForViewDto
 *
 * @OA\Schema(
 *     title="GetTabungForViewDto Schema"
 * )
 */
class GetTabungForViewDto
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
    private $nama_tabung;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $kategori_tabung;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_tabung;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_baki;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $baki_bawaan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $tarikh_akhir_peruntukan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $peruntukan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_keseluruhan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_perbelanjaan_semasa;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_baki_semasa;

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
