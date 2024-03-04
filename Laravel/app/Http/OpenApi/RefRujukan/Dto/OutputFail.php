<?php


namespace App\Http\Models\File;

/**
 * Class OutputFail
 *
 * @OA\Schema(
 *     title="OutputFail model",
 * )
 */
class OutputFail
{
    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $file_extension;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $file_location;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $file_name;
}