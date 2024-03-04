<?php

namespace app\Http\OpenApi;

/**
 * Class GetMangsaPinjamanForEditDto
 *
 * @OA\Schema(
 *     title="GetMangsaPinjamanForEditDto Schema"
 * )
 */
class GetMangsaPinjamanForEditDto
{
    /**
     * @OA\Property(
     *     title="MangsaPinjaman Model",
     *     ref="#/components/schemas/CreateOrEditMangsaPinjamanDto"
     * )
     *
     * @var object
     */
    private $mangsa_pinjaman;
}
