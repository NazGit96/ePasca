<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditMangsaDto
 *
 * @OA\Schema(
 *     title="CreateOrEditMangsaDto Schema"
 * )
 */
class CreateOrEditMangsaDto
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
    private $nama;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $no_kp;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $telefon;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $alamat_1;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $alamat_2;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_daerah;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_parlimen;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_dun;

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
    private $poskod;

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
    private $status_mangsa;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_verifikasi;

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

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $sebab_hapus;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $gambar;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_bantuan;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_bantuan;

}
