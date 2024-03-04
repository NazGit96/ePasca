<?php

namespace app\Http\OpenApi;

/**
 * Class GetMangsaForEditDto
 *
 * @OA\Schema(
 *     title="GetMangsaForEditDto Schema"
 * )
 */
class GetMangsaForEditDto
{
    /**
     * @OA\Property(
     *     title="Mangsa Model",
     *     ref="#/components/schemas/CreateOrEditMangsaDto"
     * )
     *
     * @var object
     */
    private $mangsa;
}
