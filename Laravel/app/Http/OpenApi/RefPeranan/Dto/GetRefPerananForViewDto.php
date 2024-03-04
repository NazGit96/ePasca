<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefPerananForViewDto
 *
 * @OA\Schema(
 *     title="GetRefPerananForViewDto Schema"
 * )
 */
class GetRefPerananForViewDto
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
    private $status_peranan;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $peranan;

}
