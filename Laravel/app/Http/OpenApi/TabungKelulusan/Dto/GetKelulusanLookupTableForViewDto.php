<?php

namespace app\Http\OpenApi;

/**
 * Class GetKelulusanLookupTableForViewDto
 *
 * @OA\Schema(
 *     title="GetKelulusanLookupTableForViewDto Schema"
 * )
 */
class GetKelulusanLookupTableForViewDto
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
    private $no_rujukan_kelulusan;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_tabung;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $jumlah_siling;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $baki_jumlah_siling;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $perihal_surat;
}
