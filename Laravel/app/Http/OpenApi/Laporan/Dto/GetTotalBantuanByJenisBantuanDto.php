<?php

/**
 * Class GetTotalBantuanByJenisBantuanDto
 *
 * @OA\Schema(
 *     description="Total Bantuan by Jenis Bantuan in Tabular model",
 *     title="GetTotalBantuanByJenisBantuanDto Schema",
 * )
 */
class GetTotalBantuanByJenisBantuanDto{

    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $kategori;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah;

}
