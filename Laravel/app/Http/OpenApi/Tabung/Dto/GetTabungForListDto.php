<?php

/**
 * Class GetTabungForListDto
 *
 * @OA\Schema(
 *     description="Tabung List in Tabular model",
 *     title="GetTabungForListDto Schema",
 * )
 */
class GetTabungForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/GetTabungForViewDto")
     * )
     *
     * @var array
     */
    private $items;
}
