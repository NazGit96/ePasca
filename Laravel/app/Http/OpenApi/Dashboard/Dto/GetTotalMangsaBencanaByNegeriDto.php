<?php

namespace app\Http\OpenApi;

/**
 * Class GetTotalMangsaBencanaByNegeriDto
 *
 * @OA\Schema(
 *     title="GetTotalMangsaBencanaByNegeriDto Schema"
 * )
 */
class GetTotalMangsaBencanaByNegeriDto
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
    private $bilBencana;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $value;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_negeri;

}
