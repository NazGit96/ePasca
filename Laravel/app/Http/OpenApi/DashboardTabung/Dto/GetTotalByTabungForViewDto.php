<?php

/**
 * Class GetTotalByTabungForViewDto
 *
 * @OA\Schema(
 *     description="Total Card by Tabung in Tabular model",
 *     title="GetTotalByTabungForViewDto Schema",
 * )
 */
class GetTotalByTabungForViewDto{

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_tabung;

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

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah_bersih;
}
