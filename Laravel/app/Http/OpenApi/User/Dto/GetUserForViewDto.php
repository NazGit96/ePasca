<?php

namespace app\Http\OpenApi;

/**
 * Class GetUserForViewDto
 *
 * @OA\Schema(
 *     title="GetUserForViewDto Schema"
 * )
 */
class GetUserForViewDto
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
     * @var integer
     */
    private $id_agensi;

        /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_kementerian;

        /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $jawatan;

        /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_peranan;

        /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_pengguna;

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
    private $nama_kementerian;

            /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $peranan;

     /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $no_kp;

    /**
     * @OA\Property(
     *  format="email"
     * )
     *
     * @var string
     */
    private $emel;

    /**
     * @OA\Property(
     *     format="date",
     * )
     *
     * @var string
     */
    private $tarikh_daftar;
}
