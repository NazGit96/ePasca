<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungBayaranWaranStatusForEditDto
 *
 * @OA\Schema(
 *     title="GetTabungBayaranWaranStatusForEditDto Schema"
 * )
 */
class GetTabungBayaranWaranStatusForEditDto
{
    /**
     * @OA\Property(
     *     title="TabungBayaranWaranStatus Model",
     *     ref="#/components/schemas/CreateOrEditTabungBayaranWaranStatusDto"
     * )
     *
     * @var object
     */
    private $tabungBayaranWaranStatus;
}
