<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefDaerahForEditDto
 *
 * @OA\Schema(
 *     title="GetRefDaerahForEditDto Schema"
 * )
 */
class GetRefDaerahForEditDto
{
    /**
     * @OA\Property(
     *     title="RefDaerah Model",
     *     ref="#/components/schemas/CreateOrEditRefDaerahDto"
     * )
     *
     * @var object
     */
    private $ref_daerah;
}
