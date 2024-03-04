<?php

/**
 * Class GetRefSumberPeruntukanForListDto
 *
 * @OA\Schema(
 *     description="RefSumberPeruntukan List in Tabular model",
 *     title="GetRefSumberPeruntukanForListDto Schema",
 * )
 */
class GetRefSumberPeruntukanForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefSumberPeruntukanDto")
     * )
     *
     * @var array
     */
    private $items;
}
        