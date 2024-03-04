<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefBencanaForEditDto
 *
 * @OA\Schema(
 *     title="GetRefBencanaForEditDto Schema"
 * )
 */
class GetRefBencanaForEditDto
{
    /**
     * @OA\Property(
     *     title="RefBencana Model",
     *     ref="#/components/schemas/CreateOrEditRefBencanaDto"
     * )
     *
     * @var object
     */
    private $ref_bencana;

    /**
     * @OA\Property(
     *     description="Id Negeri in array of integer",
     *     title="Negeri",
     *     @OA\Items(
     *         type="integer"
     *     )
     * )
     *
     * @var array
     */
    private $bencanaNegeri;

}
