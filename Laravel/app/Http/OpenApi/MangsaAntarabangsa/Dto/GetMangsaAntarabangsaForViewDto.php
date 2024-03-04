<?php

namespace app\Http\OpenApi;

/**
 * Class GetMangsaAntarabangsaForViewDto
 *
 * @OA\Schema(
 *     title="GetMangsaAntarabangsaForViewDto Schema"
 * )
 */
class GetMangsaAntarabangsaForViewDto
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
    private $id_bencana;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_mangsa;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $negara;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_mangsa_antarabangsa;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_pengguna_cipta;

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
    private $id_agensi;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_pengguna_kemaskini;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_kemaskini;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_bantuan;


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
    private $kos_bantuan;

        /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_bencana;
}
