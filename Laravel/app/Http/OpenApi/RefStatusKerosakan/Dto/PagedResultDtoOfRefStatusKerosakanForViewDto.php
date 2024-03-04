<?php

/**
 * Class PagedResultDtoOfRefStatusKerosakanForViewDto
 *
 * @OA\Schema(
 *     description="RefStatusKerosakan List in Tabular model",
 *     title="PagedResultDtoOfRefStatusKerosakanForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefStatusKerosakanForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefStatusKerosakanForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        