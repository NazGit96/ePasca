<?php

/**
 * Class GetRefBencanaNegeriForListDto
 *
 * @OA\Schema(
 *     description="RefBencanaNegeri List in Tabular model",
 *     title="GetRefBencanaNegeriForListDto Schema",
 * )
 */
class GetRefBencanaNegeriForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefBencanaNegeriDto")
     * )
     *
     * @var array
     */
    private $items;
}
        