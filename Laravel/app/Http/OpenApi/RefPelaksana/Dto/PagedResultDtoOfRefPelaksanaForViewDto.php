<?php

/**
 * Class PagedResultDtoOfRefPelaksanaForViewDto
 *
 * @OA\Schema(
 *     description="RefPelaksana List in Tabular model",
 *     title="PagedResultDtoOfRefPelaksanaForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefPelaksanaForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefPelaksanaForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        