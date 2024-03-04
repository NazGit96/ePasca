<?php

namespace app\Http\OpenApi;

/**
 * Class CreateMultipleMangsaWangIhsanDto
 *
 * @OA\Schema(
 *     title="CreateMultipleMangsaWangIhsanDto Schema"
 * )
 */
class CreateMultipleMangsaWangIhsanDto
{

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
     * @var integer
     */
    private $id_agensi_bantuan;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_serahan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_mangsa_wang_ihsan;

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
    private $id_jenis_bwi;

}
