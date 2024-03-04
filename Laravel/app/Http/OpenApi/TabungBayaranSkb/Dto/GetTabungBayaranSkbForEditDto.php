<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungBayaranSkbForEditDto
 *
 * @OA\Schema(
 *     title="GetTabungBayaranSkbForEditDto Schema"
 * )
 */
class GetTabungBayaranSkbForEditDto
{
    /**
     * @OA\Property(
     *     title="TabungBayaranSkb Model",
     *     ref="#/components/schemas/CreateOrEditTabungBayaranSkbDto"
     * )
     *
     * @var object
     */
    private $tabung_bayaran_skb;

}
