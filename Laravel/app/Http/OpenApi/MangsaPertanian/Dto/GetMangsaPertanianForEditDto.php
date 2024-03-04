<?php

namespace app\Http\OpenApi;

/**
 * Class GetMangsaPertanianForEditDto
 *
 * @OA\Schema(
 *     title="GetMangsaPertanianForEditDto Schema"
 * )
 */
class GetMangsaPertanianForEditDto
{
    /**
     * @OA\Property(
     *     title="MangsaPertanian Model",
     *     ref="#/components/schemas/CreateOrEditMangsaPertanianDto"
     * )
     *
     * @var object
     */
    private $mangsa_pertanian;
}
