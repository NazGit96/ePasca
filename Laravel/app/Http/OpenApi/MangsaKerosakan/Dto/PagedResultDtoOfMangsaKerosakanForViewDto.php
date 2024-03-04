<?php

/**
 * Class PagedResultDtoOfMangsaKerosakanForViewDto
 *
 * @OA\Schema(
 *     description="MangsaKerosakan List in Tabular model",
 *     title="PagedResultDtoOfMangsaKerosakanForViewDto Schema",
 * )
 */
class PagedResultDtoOfMangsaKerosakanForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetMangsaKerosakanForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        