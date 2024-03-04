<?php

namespace app\Http\OpenApi;

/**
 * Class GetMangsaRumahForEditDto
 *
 * @OA\Schema(
 *     title="GetMangsaRumahForEditDto Schema"
 * )
 */
class GetMangsaRumahForEditDto
{
    /**
     * @OA\Property(
     *     title="MangsaRumah Model",
     *     ref="#/components/schemas/CreateOrEditMangsaRumahDto"
     * )
     *
     * @var object
     */
    private $mangsa_rumah;
}
