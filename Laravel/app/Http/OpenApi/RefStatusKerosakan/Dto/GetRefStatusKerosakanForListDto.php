<?php

/**
 * Class GetRefStatusKerosakanForListDto
 *
 * @OA\Schema(
 *     description="RefStatusKerosakan List in Tabular model",
 *     title="GetRefStatusKerosakanForListDto Schema",
 * )
 */
class GetRefStatusKerosakanForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefStatusKerosakanDto")
     * )
     *
     * @var array
     */
    private $items;
}
        