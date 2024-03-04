<?php

/**
 * Class GetRefKadarBwiForListDto
 *
 * @OA\Schema(
 *     description="RefKadarBwi List in Tabular model",
 *     title="GetRefKadarBwiForListDto Schema",
 * )
 */
class GetRefKadarBwiForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefKadarBwiDto")
     * )
     *
     * @var array
     */
    private $items;
}
