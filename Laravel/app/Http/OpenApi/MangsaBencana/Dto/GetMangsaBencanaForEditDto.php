<?php

namespace app\Http\OpenApi;

/**
 * Class GetMangsaBencanaForEditDto
 *
 * @OA\Schema(
 *     title="GetMangsaBencanaForEditDto Schema"
 * )
 */
class GetMangsaBencanaForEditDto
{
    /**
     * @OA\Property(
     *     title="MangsaBencana Model",
     *     ref="#/components/schemas/CreateOrEditMangsaBencanaDto"
     * )
     *
     * @var object
     */
    private $mangsa_bencana;
}
