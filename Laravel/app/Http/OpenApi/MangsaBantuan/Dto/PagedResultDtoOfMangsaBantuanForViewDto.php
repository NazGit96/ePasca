<?php

/**
 * Class PagedResultDtoOfMangsaBantuanForViewDto
 *
 * @OA\Schema(
 *     description="MangsaBantuan List in Tabular model",
 *     title="PagedResultDtoOfMangsaBantuanForViewDto Schema",
 * )
 */
class PagedResultDtoOfMangsaBantuanForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetMangsaBantuanForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
        