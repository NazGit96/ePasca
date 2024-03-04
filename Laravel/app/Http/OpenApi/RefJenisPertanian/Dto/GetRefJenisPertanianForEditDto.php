<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefJenisPertanianForEditDto
 *
 * @OA\Schema(
 *     title="GetRefJenisPertanianForEditDto Schema"
 * )
 */
class GetRefJenisPertanianForEditDto
{
    /**
     * @OA\Property(
     *     title="RefJenisPertanian Model",
     *     ref="#/components/schemas/CreateOrEditRefJenisPertanianDto"
     * )
     *
     * @var object
     */
    private $ref_jenis_pertanian;
}
