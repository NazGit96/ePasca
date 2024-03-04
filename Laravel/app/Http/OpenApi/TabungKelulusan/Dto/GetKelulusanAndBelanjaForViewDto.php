<?php

namespace app\Http\OpenApi;

/**
 * Class GetKelulusanAndBelanjaForViewDto
 *
 * @OA\Schema(
 *     title="GetKelulusanAndBelanjaForViewDto Schema"
 * )
 */
class GetKelulusanAndBelanjaForViewDto
{
    /**
     * @OA\Property(
     *     title="RefBencana Model",
     *     ref="#/components/schemas/GetTabungKelulusanForViewDto"
     * )
     *
     * @var object
     */
    private $kelulusan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $belanja;
}
