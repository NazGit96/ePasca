<?php

/**
 * Class PagedResultDtoOfBayaranTerusLookupDto
 *
 * @OA\Schema(
 *     description="TabungBayaranTerus List in Tabular model",
 *     title="PagedResultDtoOfBayaranTerusLookupDto Schema",
 * )
 */
class PagedResultDtoOfBayaranTerusLookupDto {

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
     *     @OA\Items(ref="#/components/schemas/GetTabungBayaranTerusLookupDto")
     * )
     *
     * @var array
     */
    private $items;
}
