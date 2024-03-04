<?php

/**
 * Class GetRefDaerahForListDto
 *
 * @OA\Schema(
 *     description="RefDaerah List in Tabular model",
 *     title="GetRefDaerahForListDto Schema",
 * )
 */
class GetRefDaerahForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefDaerahDto")
     * )
     *
     * @var array
     */
    private $items;
}
        