<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditMangsaWangIhsanDto
 *
 * @OA\Schema(
 *     title="CreateOrEditMangsaWangIhsanDto Schema"
 * )
 */
class CreateOrEditMangsaWangIhsanDto
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
    private $id_bencana;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_mangsa;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_agensi_bantuan;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_serahan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_sumber_dana;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_mangsa_wang_ihsan;

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
    private $id_agensi;

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
    private $jumlah_dipulangkan;

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

}
