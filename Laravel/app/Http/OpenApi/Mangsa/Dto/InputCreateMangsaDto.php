<?php

namespace app\Http\OpenApi;

/**
 * Class InputCreateMangsaDto
 *
 * @OA\Schema(
 *     title="InputCreateMangsaDto Schema"
 * )
 */
class InputCreateMangsaDto
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

    /**
     * @OA\Property(
     *     title="Bencana Model",
     *     ref="#/components/schemas/InputBencanaMangsaDto"
     * )
     *
     * @var object
     */
    private $bencana;
}
