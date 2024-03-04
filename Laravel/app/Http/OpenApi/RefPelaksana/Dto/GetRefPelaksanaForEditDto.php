<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefPelaksanaForEditDto
 *
 * @OA\Schema(
 *     title="GetRefPelaksanaForEditDto Schema"
 * )
 */
class GetRefPelaksanaForEditDto
{
    /**
     * @OA\Property(
     *     title="RefPelaksana Model",
     *     ref="#/components/schemas/CreateOrEditRefPelaksanaDto"
     * )
     *
     * @var object
     */
    private $ref_pelaksana;
}
