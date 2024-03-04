<?php

namespace app\Http\OpenApi;

/**
 * Class PenggunaProfilDto
 *
 * @OA\Schema(
 *     title="PenggunaProfilDto Schema"
 * )
 */
class PenggunaProfilDto
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
    private $id_kementerian;

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
     * @var string
     */
    private $no_kp;

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
    private $telefon_pejabat;

        /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $telefon_bimbit;

      /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $fax;

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
     *  format="password"
     * )
     *
     * @var string
     */
    private $kata_laluan;

        /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_peranan;

        /**
     * @OA\Property(
     *  format="password"
     * )
     *
     * @var string
     */
    private $poskod;

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
     * @var string
     */
    private $gambar;
}
