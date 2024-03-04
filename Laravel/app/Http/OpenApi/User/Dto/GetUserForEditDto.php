<?php

namespace app\Http\OpenApi;

/**
 * Class GetUserForEditDto
 *
 * @OA\Schema(
 *     title="GetUserForEditDto Schema"
 * )
 */
class GetUserForEditDto
{
       /**
     * @OA\Property(
     *     title="User Model",
     *     ref="#/components/schemas/EditUserDto"
     * )
     *
     * @var object
     */
    private $pengguna;

    /**
     * @OA\Property(
     *     description="Capaian in array of string",
     *     title="Capaian",
     *     @OA\Items(
     *         type="string"
     *     )
     * )
     *
     * @var array
     */
    private $capaian_dibenarkan;
}
