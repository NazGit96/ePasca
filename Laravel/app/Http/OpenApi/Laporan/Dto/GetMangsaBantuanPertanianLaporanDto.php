<?php

namespace app\Http\OpenApi;

/**
 * Class GetMangsaBantuanPertanianLaporanDto
 *
 * @OA\Schema(
 *     title="GetMangsaBantuanPertanianLaporanDto Schema"
 * )
 */
class GetMangsaBantuanPertanianLaporanDto
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
     * @var string
     */
    private $nama_negeri;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_daerah;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_agensi;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_jenis_pertanian;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $luas;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $luas_musnah;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $bilangan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $bilangan_rosak;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $anggaran_nilai_rosak;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $anggaran_nilai_bantuan;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_bantuan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $kos_bantuan;

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

}
