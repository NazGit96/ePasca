<?php

/**
 * Class TotalBayaranTerusByMonth
 *
 * @OA\Schema(
 *     description="Total Belanja and Tanggungan by Tabung in Tabular model",
 *     title="TotalBayaranTerusByMonth Schema",
 * )
 */
class TotalBayaranTerusByMonth{

    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/GetTotalBayaranTerusByMonthForViewDto")
     * )
     *
     * @var array
     */
    private $items;

}
