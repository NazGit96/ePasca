<?php

/**
 * Class PagedResultDtoOfMangsaRumahForViewDto
 *
 * @OA\Schema(
 *     description="MangsaRumah List in Tabular model",
 *     title="PagedResultDtoOfMangsaRumahForViewDto Schema",
 * )
 */
class PagedResultDtoOfMangsaRumahForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetMangsaRumahForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        