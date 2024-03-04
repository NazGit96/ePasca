<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungBayaranSkbStatusForEditDto
 *
 * @OA\Schema(
 *     title="GetTabungBayaranSkbStatusForEditDto Schema"
 * )
 */
class GetTabungBayaranSkbStatusForEditDto
{
    /**
     * @OA\Property(
     *     title="TabungBayaranSkbStatus Model",
     *     ref="#/components/schemas/CreateOrEditTabungBayaranSkbStatusDto"
     * )
     *
     * @var object
     */
    private $tabungBayaranSkbStatus;
}
