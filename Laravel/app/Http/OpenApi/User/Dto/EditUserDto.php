<?php

namespace app\Http\OpenApi;

/**
 * Class EditUserDto
 *
 * @OA\Schema(
 *     title="EditUserDto Schema"
 * )
 */
class EditUserDto
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
     * )
     *
     * @var string
     */
    private $emel;

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
    private $nama_negeri;

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
     * @var string
     */
    private $catatan;
}
