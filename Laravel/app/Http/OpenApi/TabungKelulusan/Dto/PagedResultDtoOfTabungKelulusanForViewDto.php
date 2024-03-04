<?php

/**
 * Class PagedResultDtoOfTabungKelulusanForViewDto
 *
 * @OA\Schema(
 *     description="TabungKelulusan List in Tabular model",
 *     title="PagedResultDtoOfTabungKelulusanForViewDto Schema",
 * )
 */
class PagedResultDtoOfTabungKelulusanForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetKelulusanAndBelanjaForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
