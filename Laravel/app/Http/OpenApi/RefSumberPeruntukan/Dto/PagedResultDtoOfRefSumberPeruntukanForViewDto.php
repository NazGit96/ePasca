<?php

/**
 * Class PagedResultDtoOfRefSumberPeruntukanForViewDto
 *
 * @OA\Schema(
 *     description="RefSumberPeruntukan List in Tabular model",
 *     title="PagedResultDtoOfRefSumberPeruntukanForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefSumberPeruntukanForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefSumberPeruntukanForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        