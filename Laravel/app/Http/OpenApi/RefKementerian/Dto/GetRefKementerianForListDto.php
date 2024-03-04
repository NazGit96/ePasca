<?php

/**
 * Class GetRefKementerianForListDto
 *
 * @OA\Schema(
 *     description="RefKementerian List in Tabular model",
 *     title="GetRefKementerianForListDto Schema",
 * )
 */
class GetRefKementerianForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefKementerianDto")
     * )
     *
     * @var array
     */
    private $items;
}
        