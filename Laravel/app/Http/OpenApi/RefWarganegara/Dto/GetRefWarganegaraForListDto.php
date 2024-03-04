<?php

/**
 * Class GetRefWarganegaraForListDto
 *
 * @OA\Schema(
 *     description="RefWarganegara List in Tabular model",
 *     title="GetRefWarganegaraForListDto Schema",
 * )
 */
class GetRefWarganegaraForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefWarganegaraDto")
     * )
     *
     * @var array
     */
    private $items;
}
        