<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungKelulusanAmbilanForViewDto
 *
 * @OA\Schema(
 *     title="GetTabungKelulusanAmbilanForViewDto Schema"
 * )
 */
class GetTabungKelulusanAmbilanForViewDto
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
    private $id_tabung_kelulusan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $baki_jumlah_siling_semasa;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $baki_jumlah_siling_baharu;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_tabung;

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
