<?php

/**
 * Class PagedResultDtoOfMangsaAirForViewDto
 *
 * @OA\Schema(
 *     description="MangsaAir List in Tabular model",
 *     title="PagedResultDtoOfMangsaAirForViewDto Schema",
 * )
 */
class PagedResultDtoOfMangsaAirForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetMangsaAirForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        