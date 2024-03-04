<?php

namespace app\Http\OpenApi;

/**
 * Class InputCreateMultipleWangIhsanDto
 *
 * @OA\Schema(
 *     title="InputCreateMultipleWangIhsanDto Schema"
 * )
 */
class InputCreateMultipleWangIhsanDto
{

    /**
     * @OA\Property(
     *     title="Mangsa BWI Model",
     *     ref="#/components/schemas/CreateMultipleMangsaWangIhsanDto"
     * )
     *
     * @var object
     */
    private $mangsaBwi;

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
