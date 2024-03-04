<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefStatusKemajuanForEditDto
 *
 * @OA\Schema(
 *     title="GetRefStatusKemajuanForEditDto Schema"
 * )
 */
class GetRefStatusKemajuanForEditDto
{
    /**
     * @OA\Property(
     *     title="RefStatusKemajuan Model",
     *     ref="#/components/schemas/CreateOrEditRefStatusKemajuanDto"
     * )
     *
     * @var object
     */
    private $ref_status_kemajuan;
}
