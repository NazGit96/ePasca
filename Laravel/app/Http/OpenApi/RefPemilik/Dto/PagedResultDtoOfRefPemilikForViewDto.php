<?php

/**
 * Class PagedResultDtoOfRefPemilikForViewDto
 *
 * @OA\Schema(
 *     description="RefPemilik List in Tabular model",
 *     title="PagedResultDtoOfRefPemilikForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefPemilikForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefPemilikForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        