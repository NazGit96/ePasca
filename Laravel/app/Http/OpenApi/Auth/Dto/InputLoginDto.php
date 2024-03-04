<?php

namespace app\Http\OpenApi;

/**
 * Class InputLoginDto
 *
 * @OA\Schema(
 *     title="InputLoginDto Schema"
 * )
 */
class InputLoginDto
{

    /**
     * @OA\Property(
     *  format="email"
     * )
     *
     * @var string
     */
    private $emel;

    /**
     * @OA\Property(
     *  format="password"
     * )
     *
     * @var string
     */
    private $kata_laluan;
}
