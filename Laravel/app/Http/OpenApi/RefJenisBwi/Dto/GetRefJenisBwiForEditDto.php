<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefJenisBwiForEditDto
 *
 * @OA\Schema(
 *     title="GetRefJenisBwiForEditDto Schema"
 * )
 */
class GetRefJenisBwiForEditDto
{
    /**
     * @OA\Property(
     *     title="RefJenisBwi Model",
     *     ref="#/components/schemas/CreateOrEditRefJenisBwiDto"
     * )
     *
     * @var object
     */
    private $ref_jenis_bwi;
}
