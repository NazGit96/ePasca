<?php

/**
 * Class PagedResultDtoOfTabungBayaranSkbStatusForViewDto
 *
 * @OA\Schema(
 *     description="TabungBayaranSkbStatus List in Tabular model",
 *     title="PagedResultDtoOfTabungBayaranSkbStatusForViewDto Schema",
 * )
 */
class PagedResultDtoOfTabungBayaranSkbStatusForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetTabungBayaranSkbStatusForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
