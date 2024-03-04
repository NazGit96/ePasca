<?php

/**
 * Class PagedResultDtoOfRefMukimForViewDto
 *
 * @OA\Schema(
 *     description="RefMukim List in Tabular model",
 *     title="PagedResultDtoOfRefMukimForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefMukimForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefMukimForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        