<?php

/**
 * Class GetTotalBayaranTerusByMonthForViewDto
 *
 * @OA\Schema(
 *     description="Total Bayaran Terus By Month in Tabular model",
 *     title="GetTotalBayaranTerusByMonthForViewDto Schema",
 * )
 */
class GetTotalBayaranTerusByMonthForViewDto{


    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $numeral_month;

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $month;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $year;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $bayaran_terus;
}
