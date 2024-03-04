<?php

/**
 * Class PagedResultDtoOfRefKategoriBayaranForViewDto
 *
 * @OA\Schema(
 *     description="RefKategoriBayaran List in Tabular model",
 *     title="PagedResultDtoOfRefKategoriBayaranForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefKategoriBayaranForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefKategoriBayaranForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        