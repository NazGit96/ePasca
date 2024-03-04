<?php

/**
 * Class GetRefPindahForListDto
 *
 * @OA\Schema(
 *     description="RefPindah List in Tabular model",
 *     title="GetRefPindahForListDto Schema",
 * )
 */
class GetRefPindahForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefPindahDto")
     * )
     *
     * @var array
     */
    private $items;
}
        