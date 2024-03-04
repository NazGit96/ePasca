<?php

namespace app\Http\OpenApi;

/**
 * Class InputForgotPasswordDto
 *
 * @OA\Schema(
 *     title="InputForgotPasswordDto Schema"
 * )
 */
class InputForgotPasswordDto
{

    /**
     * @OA\Property(
     *  format="email"
     * )
     *
     * @var string
     */
    private $emel;
}
