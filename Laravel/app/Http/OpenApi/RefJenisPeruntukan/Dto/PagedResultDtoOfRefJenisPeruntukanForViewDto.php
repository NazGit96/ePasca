<?php

/**
 * Class PagedResultDtoOfRefJenisPeruntukanForViewDto
 *
 * @OA\Schema(
 *     description="RefJenisPeruntukan List in Tabular model",
 *     title="PagedResultDtoOfRefJenisPeruntukanForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefJenisPeruntukanForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefJenisPeruntukanForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        