<?php

/**
 * Class GetRefDunForListDto
 *
 * @OA\Schema(
 *     description="RefDun List in Tabular model",
 *     title="GetRefDunForListDto Schema",
 * )
 */
class GetRefDunForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefDunDto")
     * )
     *
     * @var array
     */
    private $items;
}
        