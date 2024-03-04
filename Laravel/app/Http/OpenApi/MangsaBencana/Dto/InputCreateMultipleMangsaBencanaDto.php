<?php

namespace app\Http\OpenApi;

/**
 * Class InputCreateMultipleMangsaBencanaDto
 *
 * @OA\Schema(
 *     title="InputCreateMultipleMangsaBencanaDto Schema"
 * )
 */
class InputCreateMultipleMangsaBencanaDto
{

    /**
     * @OA\Property(
     *     title="Mangsa BWI Model",
     *     ref="#/components/schemas/CreateOrEditMangsaBencanaDto"
     * )
     *
     * @var object
     */
    private $mangsaBencana;

    /**
     * @OA\Property(
     *     description="Id Mangsa in array of integer",
     *     title="Negeri",
     *     @OA\Items(
     *         type="integer"
     *     )
     * )
     *
     * @var array
     */
    private $id_mangsa;


}
