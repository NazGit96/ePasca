<?php

/**
 * Class PagedResultDtoOfRefPinjamanPerniagaanForViewDto
 *
 * @OA\Schema(
 *     description="RefPinjamanPerniagaan List in Tabular model",
 *     title="PagedResultDtoOfRefPinjamanPerniagaanForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefPinjamanPerniagaanForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefPinjamanPerniagaanForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        