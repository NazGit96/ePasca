<?php

/**
 * Class PagedResultDtoOfRefPindahForViewDto
 *
 * @OA\Schema(
 *     description="RefPindah List in Tabular model",
 *     title="PagedResultDtoOfRefPindahForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefPindahForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefPindahForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        