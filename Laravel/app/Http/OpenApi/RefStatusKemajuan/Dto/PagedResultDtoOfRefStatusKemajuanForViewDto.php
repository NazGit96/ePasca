<?php

/**
 * Class PagedResultDtoOfRefStatusKemajuanForViewDto
 *
 * @OA\Schema(
 *     description="RefStatusKemajuan List in Tabular model",
 *     title="PagedResultDtoOfRefStatusKemajuanForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefStatusKemajuanForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefStatusKemajuanForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        