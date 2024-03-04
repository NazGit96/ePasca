<?php

/**
 * Class PagedResultDtoOfSejarahTransaksiDto
 *
 * @OA\Schema(
 *     description="Tabung List in Tabular model",
 *     title="PagedResultDtoOfSejarahTransaksiDto Schema",
 * )
 */
class PagedResultDtoOfSejarahTransaksiDto {

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
     *     @OA\Items(ref="#/components/schemas/GetSejarahTransaksiDto")
     * )
     *
     * @var array
     */
    private $items;
}
