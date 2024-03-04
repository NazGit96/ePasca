<?php

namespace app\Http\OpenApi;

/**
 * Class TotalTabungCardForViewDto
 *
 * @OA\Schema(
 *     title="TotalTabungCardForViewDto Schema"
 * )
 */
class TotalTabungCardForViewDto
{

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $total_keseluruhan_semasa;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $total_peruntukan;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $total_baki_semasa;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $total_baki_bawaan;
}
