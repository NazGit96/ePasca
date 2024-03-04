<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefKadarBwiForEditDto
 *
 * @OA\Schema(
 *     title="GetRefKadarBwiForEditDto Schema"
 * )
 */
class GetRefKadarBwiForEditDto
{
    /**
     * @OA\Property(
     *     title="RefKadarBwi Model",
     *     ref="#/components/schemas/CreateOrEditRefKadarBwiDto"
     * )
     *
     * @var object
     */
    private $ref_kadar_bwi;
}
