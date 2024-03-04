<?php

namespace app\Http\OpenApi;

/**
 * Class GetMangsaBencanaForLookupDto
 *
 * @OA\Schema(
 *     title="GetMangsaBencanaForLookupDto Schema"
 * )
 */
class GetMangsaBencanaForLookupDto
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

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $tahun_bencana;

}
