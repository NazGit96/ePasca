<?php

namespace app\Http\OpenApi;

/**
 * Class GetMangsaKerosakanForEditDto
 *
 * @OA\Schema(
 *     title="GetMangsaKerosakanForEditDto Schema"
 * )
 */
class GetMangsaKerosakanForEditDto
{
    /**
     * @OA\Property(
     *     title="MangsaKerosakan Model",
     *     ref="#/components/schemas/CreateOrEditMangsaKerosakanDto"
     * )
     *
     * @var object
     */
    private $mangsa_kerosakan;
}
