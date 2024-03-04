<?php

namespace app\Http\OpenApi;

/**
 * Class GetTabungKelulusanAmbilanForEditDto
 *
 * @OA\Schema(
 *     title="GetTabungKelulusanAmbilanForEditDto Schema"
 * )
 */
class GetTabungKelulusanAmbilanForEditDto
{
    /**
     * @OA\Property(
     *     title="TabungKelulusanAmbilan Model",
     *     ref="#/components/schemas/CreateOrEditTabungKelulusanAmbilanDto"
     * )
     *
     * @var object
     */
    private $tabung_kelulusan_ambilan;
}
