<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefBencanaNegeriForEditDto
 *
 * @OA\Schema(
 *     title="GetRefBencanaNegeriForEditDto Schema"
 * )
 */
class GetRefBencanaNegeriForEditDto
{
    /**
     * @OA\Property(
     *     title="RefBencanaNegeri Model",
     *     ref="#/components/schemas/CreateOrEditRefBencanaNegeriDto"
     * )
     *
     * @var object
     */
    private $ref_bencana_negeri;
}
