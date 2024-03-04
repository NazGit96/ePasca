<?php

/**
 * Class PagedResultDtoOfRefHubunganForViewDto
 *
 * @OA\Schema(
 *     description="RefHubungan List in Tabular model",
 *     title="PagedResultDtoOfRefHubunganForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefHubunganForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefHubunganForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        