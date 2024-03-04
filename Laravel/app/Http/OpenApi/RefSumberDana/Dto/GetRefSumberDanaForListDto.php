<?php

/**
 * Class GetRefSumberDanaForListDto
 *
 * @OA\Schema(
 *     description="RefSumberDana List in Tabular model",
 *     title="GetRefSumberDanaForListDto Schema",
 * )
 */
class GetRefSumberDanaForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefSumberDanaDto")
     * )
     *
     * @var array
     */
    private $items;
}
        