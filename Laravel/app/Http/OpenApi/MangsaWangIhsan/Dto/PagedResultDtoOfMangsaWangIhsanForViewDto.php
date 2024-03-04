<?php

/**
 * Class PagedResultDtoOfMangsaWangIhsanForViewDto
 *
 * @OA\Schema(
 *     description="MangsaWangIhsan List in Tabular model",
 *     title="PagedResultDtoOfMangsaWangIhsanForViewDto Schema",
 * )
 */
class PagedResultDtoOfMangsaWangIhsanForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetMangsaWangIhsanForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        