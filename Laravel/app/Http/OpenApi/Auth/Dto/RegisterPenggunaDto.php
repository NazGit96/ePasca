<?php

namespace app\Http\OpenApi;

/**
 * Class RegisterPenggunaDto
 *
 * @OA\Schema(
 *     title="RegisterPenggunaDto Schema"
 * )
 */
class RegisterPenggunaDto
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
    private $alamat1;

      /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $alamat2;

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
}
