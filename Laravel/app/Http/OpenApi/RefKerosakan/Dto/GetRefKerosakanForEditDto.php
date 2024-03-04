<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefKerosakanForEditDto
 *
 * @OA\Schema(
 *     title="GetRefKerosakanForEditDto Schema"
 * )
 */
class GetRefKerosakanForEditDto
{
    /**
     * @OA\Property(
     *     title="RefKerosakan Model",
     *     ref="#/components/schemas/CreateOrEditRefKerosakanDto"
     * )
     *
     * @var object
     */
    private $ref_kerosakan;
}
