<?php

/**
 * Class TotalSkbByMonth
 *
 * @OA\Schema(
 *     description="Total Belanja and Tanggungan by Tabung in Tabular model",
 *     title="TotalSkbByMonth Schema",
 * )
 */
class TotalSkbByMonth{

    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/GetTotalSkbByMonthForViewDto")
     * )
     *
     * @var array
     */
    private $items;

}
