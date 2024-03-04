<?php

namespace app\Http\OpenApi;

/**
 * Class InputCreateBwiTabungBayaranDto
 *
 * @OA\Schema(
 *     title="InputCreateBwiTabungBayaranDto Schema"
 * )
 */
class InputCreateBwiTabungBayaranDto
{

    /**
     * @OA\Property(
     *     description="Array of kluster object",
     *     title="BwiKir Model",
     *     @OA\Items(ref="#/components/schemas/UpdateBwiBayaranDto")
     * )
     *
     * @var array
     */
    private $bwi_bayaran;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_tabung_bwi;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_kelulusan;

}
