<?php

/**
 * Class PagedResultDtoOfRefWarganegaraForViewDto
 *
 * @OA\Schema(
 *     description="RefWarganegara List in Tabular model",
 *     title="PagedResultDtoOfRefWarganegaraForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefWarganegaraForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefWarganegaraForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        