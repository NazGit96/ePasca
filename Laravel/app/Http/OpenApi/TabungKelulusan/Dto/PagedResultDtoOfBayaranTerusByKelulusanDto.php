<?php

/**
 * Class PagedResultDtoOfBayaranTerusByKelulusanDto
 *
 * @OA\Schema(
 *     description="TabungKelulusan List in Tabular model",
 *     title="PagedResultDtoOfBayaranTerusByKelulusanDto Schema",
 * )
 */
class PagedResultDtoOfBayaranTerusByKelulusanDto {

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
     *     description="Total Sum Bayaran Terus",
     *     title="Total Sum Bayaran Terus",
     * )
     *
     * @var integer
     */
    private $total_terus;

    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/GetBayaranTerusByIdKelulusanDto")
     * )
     *
     * @var array
     */
    private $items;
}
