<?php

/**
 * Class PagedResultDtoOfRefJenisPertanianForViewDto
 *
 * @OA\Schema(
 *     description="RefJenisPertanian List in Tabular model",
 *     title="PagedResultDtoOfRefJenisPertanianForViewDto Schema",
 * )
 */
class PagedResultDtoOfRefJenisPertanianForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetRefJenisPertanianForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        