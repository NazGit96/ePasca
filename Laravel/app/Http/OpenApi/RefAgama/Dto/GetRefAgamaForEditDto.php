<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefAgamaForEditDto
 *
 * @OA\Schema(
 *     title="GetRefAgamaForEditDto Schema"
 * )
 */
class GetRefAgamaForEditDto
{
    /**
     * @OA\Property(
     *     title="RefAgama Model",
     *     ref="#/components/schemas/CreateOrEditRefAgamaDto"
     * )
     *
     * @var object
     */
    private $ref_agama;
}
