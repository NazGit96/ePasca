<?php

/**
 * Class PagedResultDtoOfRefParlimenForViewDto
 *
 * @OA\Schema(
 *     description="RefParlimen List in Tabular model",
 *     title="PagedResultDtoOfRefParlimenForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefParlimenForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefParlimenForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        