<?php

/**
 * Class GetRefPinjamanPerniagaanForListDto
 *
 * @OA\Schema(
 *     description="RefPinjamanPerniagaan List in Tabular model",
 *     title="GetRefPinjamanPerniagaanForListDto Schema",
 * )
 */
class GetRefPinjamanPerniagaanForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefPinjamanPerniagaanDto")
     * )
     *
     * @var array
     */
    private $items;
}
        