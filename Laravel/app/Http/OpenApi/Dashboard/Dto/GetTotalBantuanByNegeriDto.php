<?php

namespace app\Http\OpenApi;

/**
 * Class GetTotalBantuanByNegeriDto
 *
 * @OA\Schema(
 *     title="GetTotalBantuanByNegeriDto Schema"
 * )
 */
class GetTotalBantuanByNegeriDto
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
    private $bilMangsa;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlahBantuan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $year;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_negeri;

}
