<?php

namespace app\Http\OpenApi;

/**
 * Class InputResetPasswordDto
 *
 * @OA\Schema(
 *     title="InputResetPasswordDto Schema"
 * )
 */
class InputResetPasswordDto
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
     * )
     *
     * @var string
     */
    private $kod_akses;

    /**
     * @OA\Property(
     *  format="password"
     * )
     *
     * @var string
     */
    private $kata_laluan;

    /**
     * @OA\Property(
     *  format="password"
     * )
     *
     * @var string
     */
    private $ulang_kata_laluan;
}
