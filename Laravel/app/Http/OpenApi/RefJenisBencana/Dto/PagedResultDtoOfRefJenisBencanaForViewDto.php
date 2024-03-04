<?php

/**
 * Class PagedResultDtoOfRefJenisBencanaForViewDto
 *
 * @OA\Schema(
 *     description="RefJenisBencana List in Tabular model",
 *     title="PagedResultDtoOfRefJenisBencanaForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefJenisBencanaForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefJenisBencanaForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        