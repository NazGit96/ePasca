<?php

/**
 * Class GetRefAgensiForListDto
 *
 * @OA\Schema(
 *     description="RefAgensi List in Tabular model",
 *     title="GetRefAgensiForListDto Schema",
 * )
 */
class GetRefAgensiForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefAgensiDto")
     * )
     *
     * @var array
     */
    private $items;
}
        