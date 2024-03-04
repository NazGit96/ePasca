<?php

namespace app\Http\OpenApi;

/**
 * Class GetMangsaWangIhsanForEditDto
 *
 * @OA\Schema(
 *     title="GetMangsaWangIhsanForEditDto Schema"
 * )
 */
class GetMangsaWangIhsanForEditDto
{
    /**
     * @OA\Property(
     *     title="MangsaWangIhsan Model",
     *     ref="#/components/schemas/CreateOrEditMangsaWangIhsanDto"
     * )
     *
     * @var object
     */
    private $mangsa_wang_ihsan;
}
