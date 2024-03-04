<?php


namespace App\Http\Models\File;

/**
 * Class OutputDownloadTempDto
 *
 * @OA\Schema(
 *     title="OutputDownloadTempDto model",
 *     description="OutputDownloadTempDto model",
 * )
 */
class OutputDownloadTempDto
{
    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $file_name;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $file_type;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $file_token;
}
