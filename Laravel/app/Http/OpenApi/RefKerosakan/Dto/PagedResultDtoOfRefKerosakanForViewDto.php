<?php

/**
 * Class PagedResultDtoOfRefKerosakanForViewDto
 *
 * @OA\Schema(
 *     description="RefKerosakan List in Tabular model",
 *     title="PagedResultDtoOfRefKerosakanForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefKerosakanForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefKerosakanForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        