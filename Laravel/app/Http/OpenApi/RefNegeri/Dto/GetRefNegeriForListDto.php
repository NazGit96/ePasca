<?php

/**
 * Class GetRefNegeriForListDto
 *
 * @OA\Schema(
 *     description="RefNegeri List in Tabular model",
 *     title="GetRefNegeriForListDto Schema",
 * )
 */
class GetRefNegeriForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefNegeriDto")
     * )
     *
     * @var array
     */
    private $items;
}
        