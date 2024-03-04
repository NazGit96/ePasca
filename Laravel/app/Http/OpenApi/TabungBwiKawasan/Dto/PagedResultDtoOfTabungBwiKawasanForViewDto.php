<?php

/**
 * Class PagedResultDtoOfTabungBwiKawasanForViewDto
 *
 * @OA\Schema(
 *     description="TabungBwiKawasan List in Tabular model",
 *     title="PagedResultDtoOfTabungBwiKawasanForViewDto Schema",
 * )
 */
class PagedResultDtoOfTabungBwiKawasanForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetTabungBwiKawasanForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        