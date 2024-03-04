<?php

/**
 * Class PagedResultDtoOfTabungPeruntukanForViewDto
 *
 * @OA\Schema(
 *     description="TabungPeruntukan List in Tabular model",
 *     title="PagedResultDtoOfTabungPeruntukanForViewDto Schema",
 * )
 */
class PagedResultDtoOfTabungPeruntukanForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetTabungPeruntukanForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        