<?php

namespace app\Http\OpenApi;

/**
 * Class GetProfilDto
 *
 * @OA\Schema(
 *     title="GetProfilDto Schema"
 * )
 */
class GetProfilDto
{
    /**
     * @OA\Property(
     *     title="Pengguna Login Info Model",
     *     ref="#/components/schemas/PenggunaProfilDto"
     * )
     *
     * @var object
     */
    private $pengguna;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $daerah;

       /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $negeri;

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
    private $kementerian;


       /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $agensi;

    /**
     * @OA\Property(
     *     description="Capaian in array of string",
     *     title="Capaian",
     *     @OA\Items(
     *         type="string"
     *     )
     * )
     *
     * @var array
     */
    private $capaian;

}
