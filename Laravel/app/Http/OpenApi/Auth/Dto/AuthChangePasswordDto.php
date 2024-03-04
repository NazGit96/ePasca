<?php

namespace app\Http\OpenApi;

/**
 * Class AuthChangePasswordDto
 *
 * @OA\Schema(
 *     title="AuthChangePasswordDto Schema"
 * )
 */
class AuthChangePasswordDto
{
    /**
     * @OA\Property(
     *  format="password"
     * )
     *
     * @var string
     */
    private $kata_laluan_baru;

    /**
     * @OA\Property(
     *  format="password"
     * )
     *
     * @var string
     */
    private $ulang_kata_laluan_baru;
}
