<?php

/**
 * Class PagedResultDtoOfMangsaAntarabangsaForViewDto
 *
 * @OA\Schema(
 *     description="MangsaAntarabangsa List in Tabular model",
 *     title="PagedResultDtoOfMangsaAntarabangsaForViewDto Schema",
 * )
 */
class PagedResultDtoOfMangsaAntarabangsaForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetMangsaAntarabangsaForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        