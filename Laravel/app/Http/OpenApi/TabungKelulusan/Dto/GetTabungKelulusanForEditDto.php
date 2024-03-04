<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungKelulusanForEditDto
 *
 * @OA\Schema(
 *     title="GetTabungKelulusanForEditDto Schema"
 * )
 */
class GetTabungKelulusanForEditDto
{
    /**
     * @OA\Property(
     *     title="TabungKelulusan Model",
     *     ref="#/components/schemas/CreateOrEditTabungKelulusanDto"
     * )
     *
     * @var object
     */
    private $tabung_kelulusan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $kategori_tabung;

}
