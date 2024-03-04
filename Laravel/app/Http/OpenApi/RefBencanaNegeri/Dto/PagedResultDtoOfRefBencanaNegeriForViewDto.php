<?php

/**
 * Class PagedResultDtoOfRefBencanaNegeriForViewDto
 *
 * @OA\Schema(
 *     description="RefBencanaNegeri List in Tabular model",
 *     title="PagedResultDtoOfRefBencanaNegeriForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefBencanaNegeriForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefBencanaNegeriForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        