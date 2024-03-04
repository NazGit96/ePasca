<?php

/**
 * Class PagedResultDtoOfWaranByKelulusanDto
 *
 * @OA\Schema(
 *     description="TabungKelulusan List in Tabular model",
 *     title="PagedResultDtoOfWaranByKelulusanDto Schema",
 * )
 */
class PagedResultDtoOfWaranByKelulusanDto {

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
     *     description="Total Sum Waran",
     *     title="Total Sum Waran",
     * )
     *
     * @var integer
     */
    private $total_waran;

    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/GetWaranByIdKelulusanDto")
     * )
     *
     * @var array
     */
    private $items;
}
