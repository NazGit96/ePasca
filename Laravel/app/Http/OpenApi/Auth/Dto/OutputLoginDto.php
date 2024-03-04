<?php

namespace app\Http\OpenApi;

/**
 * Class OutputLoginDto
 *
 * @OA\Schema(
 *     title="OutputLoginDto Schema"
 * )
 */
class OutputLoginDto
{

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $access_token;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $token_type;

       /**
     * @OA\Property(
     * )
     *
     * @var boolean
     */
    private $tukar_kata_laluan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $expires_in;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $message;
}
