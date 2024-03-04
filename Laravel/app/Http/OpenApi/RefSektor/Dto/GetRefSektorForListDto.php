<?php

/**
 * Class GetRefSektorForListDto
 *
 * @OA\Schema(
 *     description="RefSektor List in Tabular model",
 *     title="GetRefSektorForListDto Schema",
 * )
 */
class GetRefSektorForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefSektorDto")
     * )
     *
     * @var array
     */
    private $items;
}
        