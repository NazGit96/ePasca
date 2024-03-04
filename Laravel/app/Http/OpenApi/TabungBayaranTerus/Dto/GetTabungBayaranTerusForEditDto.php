<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungBayaranTerusForEditDto
 *
 * @OA\Schema(
 *     title="GetTabungBayaranTerusForEditDto Schema"
 * )
 */
class GetTabungBayaranTerusForEditDto
{
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $bwiCount;

    /**
     * @OA\Property(
     *     title="TabungBayaranTerus Model",
     *     ref="#/components/schemas/CreateOrEditTabungBayaranTerusDto"
     * )
     *
     * @var object
     */
    private $tabung_bayaran_terus;
}
