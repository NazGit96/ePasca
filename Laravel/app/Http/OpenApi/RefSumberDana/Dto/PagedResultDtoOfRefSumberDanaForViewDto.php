<?php

/**
 * Class PagedResultDtoOfRefSumberDanaForViewDto
 *
 * @OA\Schema(
 *     description="RefSumberDana List in Tabular model",
 *     title="PagedResultDtoOfRefSumberDanaForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefSumberDanaForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefSumberDanaForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        