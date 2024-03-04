<?php

/**
 * Class GetRefPerananForListDto
 *
 * @OA\Schema(
 *     description="RefPeranan List in Tabular model",
 *     title="GetRefPerananForListDto Schema",
 * )
 */
class GetRefPerananForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefPerananDto")
     * )
     *
     * @var array
     */
    private $items;
}
        