<?php

namespace app\Http\OpenApi;

/**
 * Class GetCapaianPerananDto
 *
 * @OA\Schema(
 *     title="GetCapaianPerananDto Schema"
 * )
 */
class GetCapaianPerananDto
{
    
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
    private $capaian;
    
}
