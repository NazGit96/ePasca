<?php

namespace app\Http\OpenApi;

/**
 * Class GetMangsaBantuanForEditDto
 *
 * @OA\Schema(
 *     title="GetMangsaBantuanForEditDto Schema"
 * )
 */
class GetMangsaBantuanForEditDto
{
    /**
     * @OA\Property(
     *     title="MangsaBantuan Model",
     *     ref="#/components/schemas/CreateOrEditMangsaBantuanDto"
     * )
     *
     * @var object
     */
    private $mangsa_bantuan;
}
