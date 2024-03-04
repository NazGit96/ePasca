<?php

/**
 * Class GetRefAgamaForListDto
 *
 * @OA\Schema(
 *     description="RefAgama List in Tabular model",
 *     title="GetRefAgamaForListDto Schema",
 * )
 */
class GetRefAgamaForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefAgamaDto")
     * )
     *
     * @var array
     */
    private $items;
}
        