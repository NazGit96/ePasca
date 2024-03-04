<?php

namespace app\Http\OpenApi;

/**
 * Class ChangePasswordDto
 *
 * @OA\Schema(
 *     title="ChangePasswordDto Schema"
 * )
 */
class ChangePasswordDto
{
    /**
     * @OA\Property(
     *  format="password"
     * )
     *
     * @var string
     */
    private $kata_laluan_lama;

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
