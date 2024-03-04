<?php

/**
 * Class GetRefPengumumanForListDto
 *
 * @OA\Schema(
 *     description="RefAgama List in Tabular model",
 *     title="GetRefPengumumanForListDto Schema",
 * )
 */
class GetRefPengumumanForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefPengumumanDto")
     * )
     *
     * @var array
     */
    private $items;
}
