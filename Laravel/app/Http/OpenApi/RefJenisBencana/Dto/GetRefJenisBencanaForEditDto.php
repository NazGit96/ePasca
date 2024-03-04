<?php

namespace app\Http\OpenApi;

/**
 * Class GetRefJenisBencanaForEditDto
 *
 * @OA\Schema(
 *     title="GetRefJenisBencanaForEditDto Schema"
 * )
 */
class GetRefJenisBencanaForEditDto
{
    /**
     * @OA\Property(
     *     title="RefJenisBencana Model",
     *     ref="#/components/schemas/CreateOrEditRefJenisBencanaDto"
     * )
     *
     * @var object
     */
    private $ref_jenis_bencana;
}
