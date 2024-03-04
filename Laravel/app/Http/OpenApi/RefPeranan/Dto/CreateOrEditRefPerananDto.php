<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefPerananDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefPerananDto Schema"
 * )
 */
class CreateOrEditRefPerananDto
{

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $peranan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_peranan;

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
