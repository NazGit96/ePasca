<?php

/**
 * Class PagedResultDtoMangsBencanaLookupTableDto
 *
 * @OA\Schema(
 *     description="MangsaBencana List in Tabular model",
 *     title="PagedResultDtoMangsBencanaLookupTableDto Schema",
 * )
 */
class PagedResultDtoMangsBencanaLookupTableDto {

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
     *     @OA\Items(ref="#/components/schemas/GetMangsaBencanaForLookupDto")
     * )
     *
     * @var array
     */
    private $items;
}
