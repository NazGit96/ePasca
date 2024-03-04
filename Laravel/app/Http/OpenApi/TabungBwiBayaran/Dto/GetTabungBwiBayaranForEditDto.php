<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungBwiBayaranForEditDto
 *
 * @OA\Schema(
 *     title="GetTabungBwiBayaranForEditDto Schema"
 * )
 */
class GetTabungBwiBayaranForEditDto
{
    /**
     * @OA\Property(
     *     title="TabungBwiBayaran Model",
     *     ref="#/components/schemas/CreateOrEditTabungBwiBayaranDto"
     * )
     *
     * @var object
     */
    private $tabung_bwi_bayaran;
}
