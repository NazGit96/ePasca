<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefParlimenForEditDto
 *
 * @OA\Schema(
 *     title="GetRefParlimenForEditDto Schema"
 * )
 */
class GetRefParlimenForEditDto
{
    /**
     * @OA\Property(
     *     title="RefParlimen Model",
     *     ref="#/components/schemas/CreateOrEditRefParlimenDto"
     * )
     *
     * @var object
     */
    private $ref_parlimen;
}
