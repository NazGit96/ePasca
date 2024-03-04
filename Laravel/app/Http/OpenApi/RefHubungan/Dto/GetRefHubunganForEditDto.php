<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefHubunganForEditDto
 *
 * @OA\Schema(
 *     title="GetRefHubunganForEditDto Schema"
 * )
 */
class GetRefHubunganForEditDto
{
    /**
     * @OA\Property(
     *     title="RefHubungan Model",
     *     ref="#/components/schemas/CreateOrEditRefHubunganDto"
     * )
     *
     * @var object
     */
    private $ref_hubungan;
}
