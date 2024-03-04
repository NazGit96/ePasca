<?php

/**
 * Class GetMangsaForListDto
 *
 * @OA\Schema(
 *     description="Mangsa List in Tabular model",
 *     title="MagsaForListDto Schema",
 * )
 */
class GetMangsaForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/MangsaDto")
     * )
     *
     * @var array
     */
    private $items;
}