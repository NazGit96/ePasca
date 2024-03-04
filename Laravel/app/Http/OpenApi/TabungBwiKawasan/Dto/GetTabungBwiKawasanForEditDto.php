<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungBwiKawasanForEditDto
 *
 * @OA\Schema(
 *     title="GetTabungBwiKawasanForEditDto Schema"
 * )
 */
class GetTabungBwiKawasanForEditDto
{
    /**
     * @OA\Property(
     *     title="TabungBwiKawasan Model",
     *     ref="#/components/schemas/CreateOrEditTabungBwiKawasanDto"
     * )
     *
     * @var object
     */
    private $tabung_bwi_kawasan;
}
