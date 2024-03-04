<?php

/**
 * Class PagedResultDtoOfRefDaerahForViewDto
 *
 * @OA\Schema(
 *     description="RefDaerah List in Tabular model",
 *     title="PagedResultDtoOfRefDaerahForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefDaerahForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefDaerahForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        