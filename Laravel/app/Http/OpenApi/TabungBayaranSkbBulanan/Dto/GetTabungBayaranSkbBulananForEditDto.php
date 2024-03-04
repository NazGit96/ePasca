<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungBayaranSkbBulananForEditDto
 *
 * @OA\Schema(
 *     title="GetTabungBayaranSkbBulananForEditDto Schema"
 * )
 */
class GetTabungBayaranSkbBulananForEditDto
{
    /**
     * @OA\Property(
     *     title="TabungBayaranSkbBulanan Model",
     *     ref="#/components/schemas/CreateOrEditTabungBayaranSkbBulananDto"
     * )
     *
     * @var object
     */
    private $tabung_bayaran_skb_bulanan;
}
