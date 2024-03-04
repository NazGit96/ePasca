<?php

/**
 * Class GetRefKerosakanForListDto
 *
 * @OA\Schema(
 *     description="RefKerosakan List in Tabular model",
 *     title="GetRefKerosakanForListDto Schema",
 * )
 */
class GetRefKerosakanForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefKerosakanDto")
     * )
     *
     * @var array
     */
    private $items;
}
        