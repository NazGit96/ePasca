<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditPenggunaDto
 *
 * @OA\Schema(
 *     title="CreateOrEditPenggunaDto Schema"
 * )
 */
class CreateOrEditPenggunaDto
{
    /**
     * @OA\Property(
     *     title="User Model",
     *     ref="#/components/schemas/CreatePenggunaDto"
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
