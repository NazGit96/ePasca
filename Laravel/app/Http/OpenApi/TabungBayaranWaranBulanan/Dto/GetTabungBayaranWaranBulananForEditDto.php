<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungBayaranWaranBulananForEditDto
 *
 * @OA\Schema(
 *     title="GetTabungBayaranWaranBulananForEditDto Schema"
 * )
 */
class GetTabungBayaranWaranBulananForEditDto
{
    /**
     * @OA\Property(
     *     title="TabungBayaranWaranBulanan Model",
     *     ref="#/components/schemas/CreateOrEditTabungBayaranWaranBulananDto"
     * )
     *
     * @var object
     */
    private $tabung_bayaran_waran_bulanan;
}
