<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefStatusKerosakanForEditDto
 *
 * @OA\Schema(
 *     title="GetRefStatusKerosakanForEditDto Schema"
 * )
 */
class GetRefStatusKerosakanForEditDto
{
    /**
     * @OA\Property(
     *     title="RefStatusKerosakan Model",
     *     ref="#/components/schemas/CreateOrEditRefStatusKerosakanDto"
     * )
     *
     * @var object
     */
    private $ref_status_kerosakan;
}
