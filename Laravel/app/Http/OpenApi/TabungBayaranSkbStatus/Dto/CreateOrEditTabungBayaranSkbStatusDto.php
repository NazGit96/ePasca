<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditTabungBayaranSkbStatusDto
 *
 * @OA\Schema(
 *     title="CreateOrEditTabungBayaranSkbStatusDto Schema"
 * )
 */
class CreateOrEditTabungBayaranSkbStatusDto
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
    private $id_tabung_bayaran_skb;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_status_skb;

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
