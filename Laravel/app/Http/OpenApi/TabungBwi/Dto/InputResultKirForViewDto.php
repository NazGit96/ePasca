<?php

/**
 * Class InputResultKirForViewDto
 *
 * @OA\Schema(
 *     description="TabungBwi List in Tabular model",
 *     title="InputResultKirForViewDto Schema",
 * )
 */
class InputResultKirForViewDto {

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
     *     @OA\Items(ref="#/components/schemas/GetAllKirForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
