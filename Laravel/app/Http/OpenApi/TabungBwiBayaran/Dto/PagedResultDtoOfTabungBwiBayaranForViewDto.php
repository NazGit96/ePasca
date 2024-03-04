<?php

/**
 * Class PagedResultDtoOfTabungBwiBayaranForViewDto
 *
 * @OA\Schema(
 *     description="TabungBwiBayaran List in Tabular model",
 *     title="PagedResultDtoOfTabungBwiBayaranForViewDto Schema",
 * )
 */
class PagedResultDtoOfTabungBwiBayaranForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetTabungBwiBayaranForViewDto")
     * )
     *
     * @var array
     */
    private $items;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_keseluruhan_bayaran;
}
