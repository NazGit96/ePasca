<?php

namespace app\Http\OpenApi;

/**
 * Class GetListBencanaNegeriForViewDto
 *
 * @OA\Schema(
 *     title="GetListBencanaNegeriForViewDto Schema"
 * )
 */
class GetListBencanaNegeriForViewDto
{
    /**
     * @OA\Property(
     *     title="RefBencana Model",
     *     ref="#/components/schemas/GetRefBencanaForViewDto"
     * )
     *
     * @var object
     */
    private $bencana;

    /**
     * @OA\Property(
     *     description="Id Negeri in array of integer",
     *     title="Negeri",
     *     @OA\Items(
     *         type="string"
     *     )
     * )
     *
     * @var array
     */
    private $bencanaNegeri;
}
