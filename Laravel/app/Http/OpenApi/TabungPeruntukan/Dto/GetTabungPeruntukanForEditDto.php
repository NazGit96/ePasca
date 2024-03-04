<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungPeruntukanForEditDto
 *
 * @OA\Schema(
 *     title="GetTabungPeruntukanForEditDto Schema"
 * )
 */
class GetTabungPeruntukanForEditDto
{
    /**
     * @OA\Property(
     *     title="TabungPeruntukan Model",
     *     ref="#/components/schemas/CreateOrEditTabungPeruntukanDto"
     * )
     *
     * @var object
     */
    private $tabung_peruntukan;
}
