<?php

namespace app\Http\OpenApi;

/**
 * Class InputCreateBencanaDto
 *
 * @OA\Schema(
 *     title="InputCreateBencanaDto Schema"
 * )
 */
class InputCreateBencanaDto
{

    /**
     * @OA\Property(
     *     title="Bencana Model",
     *     ref="#/components/schemas/CreateOrEditRefBencanaDto"
     * )
     *
     * @var object
     */
    private $bencana;

    /**
     * @OA\Property(
     *     description="Id Negeri in array of integer",
     *     title="Negeri",
     *     @OA\Items(
     *         type="integer"
     *     )
     * )
     *
     * @var array
     */
    private $id_negeri;


}
