<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefKadarBwiForViewDto
 *
 * @OA\Schema(
 *     title="GetRefKadarBwiForViewDto Schema"
 * )
 */
class GetRefKadarBwiForViewDto
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
    private $nilai;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_bencana_bwi;

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
     * @var string
     */
    private $id_pengguna_cipta;

}
