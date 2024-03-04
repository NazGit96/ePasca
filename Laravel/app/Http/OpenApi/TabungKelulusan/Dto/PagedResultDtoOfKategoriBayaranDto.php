<?php

/**
 * Class PagedResultDtoOfKategoriBayaranDto
 *
 * @OA\Schema(
 *     description="TabungKelulusan List in Tabular model",
 *     title="PagedResultDtoOfKategoriBayaranDto Schema",
 * )
 */
class PagedResultDtoOfKategoriBayaranDto {

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
     *     @OA\Items(ref="#/components/schemas/GetKelulusanByKategoriBayaranDto")
     * )
     *
     * @var array
     */
    private $items;
}
