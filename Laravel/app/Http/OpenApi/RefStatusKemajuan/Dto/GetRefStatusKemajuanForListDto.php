<?php

/**
 * Class GetRefStatusKemajuanForListDto
 *
 * @OA\Schema(
 *     description="RefStatusKemajuan List in Tabular model",
 *     title="GetRefStatusKemajuanForListDto Schema",
 * )
 */
class GetRefStatusKemajuanForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefStatusKemajuanDto")
     * )
     *
     * @var array
     */
    private $items;
}
        