<?php

/**
 * Class GetTotalTabungCardForViewDto
 *
 * @OA\Schema(
 *     description="Total Tabung in Tabular model",
 *     title="GetTotalTabungCardForViewDto Schema",
 * )
 */
class GetTotalTabungCardForViewDto{

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_keseluruhan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_perbelanjaan_semasa;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_tanggungan;
}
