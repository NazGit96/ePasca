<?php

namespace app\Http\OpenApi;

/**
 * Class InputCreateBwiTabungKawasanDto
 *
 * @OA\Schema(
 *     title="InputCreateBwiTabungKawasanDto Schema"
 * )
 */
class InputCreateBwiTabungKawasanDto
{
    /**
     * @OA\Property(
     *     description="Array of kluster object",
     *     title="BwiKir Model",
     *     @OA\Items(ref="#/components/schemas/CreateOrEditTabungBwiKawasanDto")
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
    private $id_tabung_bwi;

}
