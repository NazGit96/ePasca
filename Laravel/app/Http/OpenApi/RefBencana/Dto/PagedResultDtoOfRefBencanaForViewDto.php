<?php

/**
 * Class PagedResultDtoOfRefBencanaForViewDto
 *
 * @OA\Schema(
 *     description="RefBencana List in Tabular model",
 *     title="PagedResultDtoOfRefBencanaForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefBencanaForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetListBencanaNegeriForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
