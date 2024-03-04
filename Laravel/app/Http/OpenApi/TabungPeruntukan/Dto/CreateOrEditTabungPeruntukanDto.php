<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditTabungPeruntukanDto
 *
 * @OA\Schema(
 *     title="CreateOrEditTabungPeruntukanDto Schema"
 * )
 */
class CreateOrEditTabungPeruntukanDto
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
    private $id_tabung;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_peruntukan;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_peruntukan;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $no_rujukan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_sumber_peruntukan;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $sumber_peruntukan_lain;

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
    private $jumlah_baru;
}
