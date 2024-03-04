<?php

/**
 * Class PagedResultDtoOfRefDunForViewDto
 *
 * @OA\Schema(
 *     description="RefDun List in Tabular model",
 *     title="PagedResultDtoOfRefDunForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefDunForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefDunForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        