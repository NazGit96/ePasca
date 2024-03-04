<?php

/**
 * Class GetRefPemilikForListDto
 *
 * @OA\Schema(
 *     description="RefPemilik List in Tabular model",
 *     title="GetRefPemilikForListDto Schema",
 * )
 */
class GetRefPemilikForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefPemilikDto")
     * )
     *
     * @var array
     */
    private $items;
}
        