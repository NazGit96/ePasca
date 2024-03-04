<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefDunForEditDto
 *
 * @OA\Schema(
 *     title="GetRefDunForEditDto Schema"
 * )
 */
class GetRefDunForEditDto
{
    /**
     * @OA\Property(
     *     title="RefDun Model",
     *     ref="#/components/schemas/CreateOrEditRefDunDto"
     * )
     *
     * @var object
     */
    private $ref_dun;
}
