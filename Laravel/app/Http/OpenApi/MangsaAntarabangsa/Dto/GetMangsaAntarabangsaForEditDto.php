<?php

namespace app\Http\OpenApi;

/**
 * Class GetMangsaAntarabangsaForEditDto
 *
 * @OA\Schema(
 *     title="GetMangsaAntarabangsaForEditDto Schema"
 * )
 */
class GetMangsaAntarabangsaForEditDto
{
    /**
     * @OA\Property(
     *     title="MangsaAntarabangsa Model",
     *     ref="#/components/schemas/CreateOrEditMangsaAntarabangsaDto"
     * )
     *
     * @var object
     */
    private $mangsa_antarabangsa;
}
