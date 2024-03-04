<?php

/**
 * Class PagedResultDtoOfRefKementerianForViewDto
 *
 * @OA\Schema(
 *     description="RefKementerian List in Tabular model",
 *     title="PagedResultDtoOfRefKementerianForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefKementerianForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefKementerianForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        