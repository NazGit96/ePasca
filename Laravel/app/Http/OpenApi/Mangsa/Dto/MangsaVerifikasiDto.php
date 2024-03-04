<?php

namespace app\Http\OpenApi;

/**
 * Class MangsaVerifikasiDto
 *
 * @OA\Schema(
 *     title="MangsaVerifikasiDto Schema"
 * )
 */
class MangsaVerifikasiDto
{
    /**
     * @OA\Property(
     *     description="Id Mangsa in array of integer",
     *     title="Negeri",
     *     @OA\Items(
     *         type="integer"
     *     )
     * )
     *
     * @var array
     */
    private $id_mangsa;
}
