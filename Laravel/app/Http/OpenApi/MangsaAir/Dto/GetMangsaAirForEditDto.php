<?php

namespace app\Http\OpenApi;

/**
 * Class GetMangsaAirForEditDto
 *
 * @OA\Schema(
 *     title="GetMangsaAirForEditDto Schema"
 * )
 */
class GetMangsaAirForEditDto
{
    /**
     * @OA\Property(
     *     title="MangsaAir Model",
     *     ref="#/components/schemas/CreateOrEditMangsaAirDto"
     * )
     *
     * @var object
     */
    private $mangsa_air;
}
