<?php

/**
 * Class PagedResultDtoOfRefJenisBwiForViewDto
 *
 * @OA\Schema(
 *     description="RefJenisBwi List in Tabular model",
 *     title="PagedResultDtoOfRefJenisBwiForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefJenisBwiForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefJenisBwiForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        