<?php

/**
 * Class PagedResultDtoOfMangsaPinjamanForViewDto
 *
 * @OA\Schema(
 *     description="MangsaPinjaman List in Tabular model",
 *     title="PagedResultDtoOfMangsaPinjamanForViewDto Schema",
 * )
 */
class PagedResultDtoOfMangsaPinjamanForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetMangsaPinjamanForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        