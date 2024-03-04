<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditTabungBwiDto
 *
 * @OA\Schema(
 *     title="CreateOrEditTabungBwiDto Schema"
 * )
 */
class CreateOrEditTabungBwiDto
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
    private $id_jenis_bwi;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_bencana;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $no_rujukan_bwi;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_jenis_bwi;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_bencana;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_bencana;

}
