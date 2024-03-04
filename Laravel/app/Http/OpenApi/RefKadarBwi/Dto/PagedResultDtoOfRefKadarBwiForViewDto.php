<?php

/**
 * Class PagedResultDtoOfRefKadarBwiForViewDto
 *
 * @OA\Schema(
 *     description="RefKadarBwi List in Tabular model",
 *     title="PagedResultDtoOfRefKadarBwiForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefKadarBwiForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefKadarBwiForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
