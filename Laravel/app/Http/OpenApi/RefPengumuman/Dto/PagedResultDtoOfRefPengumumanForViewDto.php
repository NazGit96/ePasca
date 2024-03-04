<?php

/**
 * Class PagedResultDtoOfRefPengumumanForViewDto
 *
 * @OA\Schema(
 *     description="RefAgama List in Tabular model",
 *     title="PagedResultDtoOfRefPengumumanForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefPengumumanForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefPengumumanForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
