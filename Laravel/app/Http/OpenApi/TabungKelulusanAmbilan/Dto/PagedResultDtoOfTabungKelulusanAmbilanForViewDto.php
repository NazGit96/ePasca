<?php

/**
 * Class PagedResultDtoOfTabungKelulusanAmbilanForViewDto
 *
 * @OA\Schema(
 *     description="TabungKelulusanAmbilan List in Tabular model",
 *     title="PagedResultDtoOfTabungKelulusanAmbilanForViewDto Schema",
 * )
 */
class PagedResultDtoOfTabungKelulusanAmbilanForViewDto {

    /**
     * @OA\Property(
     *     description="Total Count",
     *     title="Total Count",
     * )
     *
     * @var integer
     */
    private $total_count;

    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/GetTabungKelulusanAmbilanForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        