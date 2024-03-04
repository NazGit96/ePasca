<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefDaerahForViewDto
 *
 * @OA\Schema(
 *     title="GetRefDaerahForViewDto Schema"
 * )
 */
class GetRefDaerahForViewDto
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
     * @var string
     */
    private $nama_daerah;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_daerah;

        /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_negeri;
}
