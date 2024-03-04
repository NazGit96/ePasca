<?php

/**
 * Class PagedResultDtoOfTabungKelulusanLookupTableForViewDto
 *
 * @OA\Schema(
 *     description="TabungKelulusan List in Tabular model",
 *     title="PagedResultDtoOfTabungKelulusanLookupTableForViewDto Schema",
 * )
 */
class PagedResultDtoOfTabungKelulusanLookupTableForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetKelulusanLookupTableForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
