<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefPengumumanForViewDto
 *
 * @OA\Schema(
 *     title="GetRefPengumumanForViewDto Schema"
 * )
 */
class GetRefPengumumanForViewDto
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
     * @var string
     */
    private $nama_pengumuman;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_mula;

    /**
     * @OA\Property(
     *     format="date-time",
     * )
     *
     * @var string
     */
    private $tarikh_tamat;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_pengumuman;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $catatan;

}
