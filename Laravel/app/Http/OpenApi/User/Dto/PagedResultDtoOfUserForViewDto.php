<?php

/**
 * Class PagedResultDtoOfUserForViewDto
 *
 * @OA\Schema(
 *     description="Ngo List in Tabular model",
 *     title="PagedResultDtoOfUserForViewDto Schema",
 * )
 */
class PagedResultDtoOfUserForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetUserForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
