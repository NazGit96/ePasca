<?php

/**
 * Class PagedResultDtoOfRefJenisBayaranForViewDto
 *
 * @OA\Schema(
 *     description="RefJenisBayaran List in Tabular model",
 *     title="PagedResultDtoOfRefJenisBayaranForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefJenisBayaranForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefJenisBayaranForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        