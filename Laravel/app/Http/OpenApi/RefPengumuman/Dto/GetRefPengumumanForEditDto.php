<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefPengumumanForEditDto
 *
 * @OA\Schema(
 *     title="GetRefPengumumanForEditDto Schema"
 * )
 */
class GetRefPengumumanForEditDto
{
    /**
     * @OA\Property(
     *     title="RefAgama Model",
     *     ref="#/components/schemas/CreateOrEditRefPengumumanDto"
     * )
     *
     * @var object
     */
    private $ref_pengumuman;
}
