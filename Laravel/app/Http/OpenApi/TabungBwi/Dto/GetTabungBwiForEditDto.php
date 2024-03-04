<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungBwiForEditDto
 *
 * @OA\Schema(
 *     title="GetTabungBwiForEditDto Schema"
 * )
 */
class GetTabungBwiForEditDto
{
    /**
     * @OA\Property(
     *     title="TabungBwi Model",
     *     ref="#/components/schemas/CreateOrEditTabungBwiDto"
     * )
     *
     * @var object
     */
    private $tabung_bwi;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_keseluruhan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_dipulangkan;
}
