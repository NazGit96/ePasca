<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefKementerianForViewDto
 *
 * @OA\Schema(
 *     title="GetRefKementerianForViewDto Schema"
 * )
 */
class GetRefKementerianForViewDto
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
    private $nama_kementerian;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $kod_kementerian;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_kementerian;

}
