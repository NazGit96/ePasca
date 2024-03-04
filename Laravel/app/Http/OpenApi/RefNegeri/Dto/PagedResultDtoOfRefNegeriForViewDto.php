<?php

/**
 * Class PagedResultDtoOfRefNegeriForViewDto
 *
 * @OA\Schema(
 *     description="RefNegeri List in Tabular model",
 *     title="PagedResultDtoOfRefNegeriForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefNegeriForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefNegeriForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        