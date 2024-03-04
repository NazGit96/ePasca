<?php

/**
 * Class PagedResultDtoOfSkbByKelulusanDto
 *
 * @OA\Schema(
 *     description="TabungKelulusan List in Tabular model",
 *     title="PagedResultDtoOfSkbByKelulusanDto Schema",
 * )
 */
class PagedResultDtoOfSkbByKelulusanDto {

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
     *     description="Total Sum SKB",
     *     title="Total Sum SKB",
     * )
     *
     * @var integer
     */
    private $total_skb;

    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/GetSkbByIdKelulusanDto")
     * )
     *
     * @var array
     */
    private $items;
}
