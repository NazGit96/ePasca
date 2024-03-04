<?php

/**
 * Class PagedResultDtoOfRefRujukanForViewDto
 *
 * @OA\Schema(
 *     description="RefRujukan List in Tabular model",
 *     title="PagedResultDtoOfRefRujukanForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefRujukanForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefRujukanForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        