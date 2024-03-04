<?php

/**
 * Class PagedResultDtoOfRefBantuanForViewDto
 *
 * @OA\Schema(
 *     description="RefBantuan List in Tabular model",
 *     title="PagedResultDtoOfRefBantuanForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefBantuanForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefBantuanForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        