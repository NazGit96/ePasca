<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungForEditDto
 *
 * @OA\Schema(
 *     title="GetTabungForEditDto Schema"
 * )
 */
class GetTabungForEditDto
{
    /**
     * @OA\Property(
     *     title="Tabung Model",
     *     ref="#/components/schemas/CreateOrEditTabungDto"
     * )
     *
     * @var object
     */
    private $tabung;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $dana_awal;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $dana_tambahan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $peruntukan_diambil;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_tanggungan;
}
