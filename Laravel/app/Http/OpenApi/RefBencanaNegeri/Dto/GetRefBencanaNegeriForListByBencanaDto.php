<?php

/**
 * Class GetRefBencanaNegeriForListByBencanaDto
 *
 * @OA\Schema(
 *     description="RefBencanaNegeri List in Tabular model",
 *     title="GetRefBencanaNegeriForListByBencanaDto Schema",
 * )
 */
class GetRefBencanaNegeriForListByBencanaDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefBencanaNegeriByBencanaDto")
     * )
     *
     * @var array
     */
    private $items;
}
