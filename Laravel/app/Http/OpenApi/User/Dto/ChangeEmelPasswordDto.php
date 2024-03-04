<?php

namespace app\Http\OpenApi;

/**
 * Class ChangeEmelPasswordDto
 *
 * @OA\Schema(
 *     title="ChangeEmelPasswordDto Schema"
 * )
 */
class ChangeEmelPasswordDto
{

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $changeEmel;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $changePassword;
}
