<?php

/**
 * Class PagedResultDtoOfMangsaBencanaForViewDto
 *
 * @OA\Schema(
 *     description="MangsaBencana List in Tabular model",
 *     title="PagedResultDtoOfMangsaBencanaForViewDto Schema",
 * )
 */
class PagedResultDtoOfMangsaBencanaForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetMangsaBencanaForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        