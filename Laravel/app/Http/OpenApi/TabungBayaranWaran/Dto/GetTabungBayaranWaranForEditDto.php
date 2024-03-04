<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungBayaranWaranForEditDto
 *
 * @OA\Schema(
 *     title="GetTabungBayaranWaranForEditDto Schema"
 * )
 */
class GetTabungBayaranWaranForEditDto
{
    /**
     * @OA\Property(
     *     title="TabungBayaranWaran Model",
     *     ref="#/components/schemas/CreateOrEditTabungBayaranWaranDto"
     * )
     *
     * @var object
     */
    private $tabung_bayaran_waran;

}
