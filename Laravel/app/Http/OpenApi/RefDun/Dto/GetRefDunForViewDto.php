<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefDunForViewDto
 *
 * @OA\Schema(
 *     title="GetRefDunForViewDto Schema"
 * )
 */
class GetRefDunForViewDto
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
     * @var integer
     */
    private $id_negeri;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id_parlimen;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $kod_dun;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_dun;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_dun;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_negeri;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_parlimen;

}
