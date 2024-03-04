<?php

/**
 * Class GetTotalSkbByMonthForViewDto
 *
 * @OA\Schema(
 *     description="Total SKB By Month in Tabular model",
 *     title="GetTotalSkbByMonthForViewDto Schema",
 * )
 */
class GetTotalSkbByMonthForViewDto{

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $bulan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $bayaran_skb;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $year;
}
