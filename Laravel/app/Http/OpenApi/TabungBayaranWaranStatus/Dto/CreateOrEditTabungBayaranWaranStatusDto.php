<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditTabungBayaranWaranStatusDto
 *
 * @OA\Schema(
 *     title="CreateOrEditTabungBayaranWaranStatusDto Schema"
 * )
 */
class CreateOrEditTabungBayaranWaranStatusDto
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
    private $id_tabung_bayaran_waran;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_status_waran;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $catatan;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_cipta;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_pengguna_cipta;

}
