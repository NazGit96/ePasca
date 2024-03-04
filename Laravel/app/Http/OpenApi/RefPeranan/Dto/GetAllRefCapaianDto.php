<?php

namespace app\Http\OpenApi;

/**
 * Class GetAllRefCapaianDto
 *
 * @OA\Schema(
 *     title="GetAllRefCapaianDto Schema"
 * )
 */
class GetAllRefCapaianDto
{
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefCapaianDto")
     * )
     *
     * @var array
     */
    private $ref_capaian;
}
