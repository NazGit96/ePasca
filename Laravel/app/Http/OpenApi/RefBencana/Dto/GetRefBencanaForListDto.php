<?php

/**
 * Class GetRefBencanaForListDto
 *
 * @OA\Schema(
 *     description="RefBencana List in Tabular model",
 *     title="GetRefBencanaForListDto Schema",
 * )
 */
class GetRefBencanaForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefBencanaDto")
     * )
     *
     * @var array
     */
    private $items;
}
        