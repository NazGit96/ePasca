<?php

/**
 * Class GetRefMukimForListDto
 *
 * @OA\Schema(
 *     description="RefMukim List in Tabular model",
 *     title="GetRefMukimForListDto Schema",
 * )
 */
class GetRefMukimForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefMukimDto")
     * )
     *
     * @var array
     */
    private $items;
}
        