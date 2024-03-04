<?php

namespace app\Http\OpenApi;

/**
 * Class GetMangsaForViewDto
 *
 * @OA\Schema(
 *     title="GetMangsaForViewDto Schema"
 * )
 */
class GetMangsaForViewDto
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
    private $nama_negeri;

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
     * @var integer
     */
    private $status_verifikasi;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $isi_rumah;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $jumlah_bantuan;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_cipta;

}
