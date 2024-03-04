<?php

namespace app\Http\OpenApi;

/**
 * Class RefCapaianDto
 *
 * @OA\Schema(
 *     title="RefCapaianDto Schema"
 * )
 */
class RefCapaianDto
{

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_paparan;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $pendahulu;

}
