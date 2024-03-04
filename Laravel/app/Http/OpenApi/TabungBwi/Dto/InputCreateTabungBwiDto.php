<?php

namespace app\Http\OpenApi;

/**
 * Class InputCreateTabungBwiDto
 *
 * @OA\Schema(
 *     title="InputCreateTabungBwiDto Schema"
 * )
 */
class InputCreateTabungBwiDto
{

    /**
     * @OA\Property(
     *     title="Bwi Model",
     *     ref="#/components/schemas/CreateOrEditTabungBwiDto"
     * )
     *
     * @var object
     */
    private $bwi;

    /**
     * @OA\Property(
     *     description="Array of kluster object",
     *     title="BwiKir Model",
     *     @OA\Items(ref="#/components/schemas/InputBwiBayaranDto")
     * )
     *
     * @var array
     */
    private $bwi_bayaran;

    /**
     * @OA\Property(
     *     description="Array of kluster object",
     *     title="BwiKir Model",
     *     @OA\Items(ref="#/components/schemas/InputBwiKawasanDto")
     * )
     *
     * @var array
     */
    private $bwi_kawasan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_kelulusan;

}
