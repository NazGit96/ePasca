<?php

/**
 * Class PagedResultOfRingkasanLaporanBwiByNegeriDto
 *
 * @OA\Schema(
 *     description="Mangsa List in Tabular model",
 *     title="PagedResultOfRingkasanLaporanBwiByNegeriDto Schema",
 * )
 */
class PagedResultOfRingkasanLaporanBwiByNegeriDto {

    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/GetRingkasanLaporanBwiByNegeriDto")
     * )
     *
     * @var array
     */
    private $items;
}
