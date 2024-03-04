<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungBwiKawasanForViewDto
 *
 * @OA\Schema(
 *     title="GetTabungBwiKawasanForViewDto Schema"
 * )
 */
class GetTabungBwiKawasanForViewDto
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
    private $id_daerah;

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
     * @var integer
     */
    private $jumlah_bwi;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_kir;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_kembali;

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
     * @var integer
     */
    private $bil_kir_belum_dibayar;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $bil_kir;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_dibayar;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_belum_dibayar;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_dipulangkan;

}
