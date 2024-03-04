<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefNegeriForEditDto
 *
 * @OA\Schema(
 *     title="GetRefNegeriForEditDto Schema"
 * )
 */
class GetRefNegeriForEditDto
{
    /**
     * @OA\Property(
     *     title="RefNegeri Model",
     *     ref="#/components/schemas/CreateOrEditRefNegeriDto"
     * )
     *
     * @var object
     */
    private $ref_negeri;
}
