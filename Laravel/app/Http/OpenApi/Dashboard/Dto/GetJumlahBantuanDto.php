<?php

/**
 * Class GetJumlahBantuanDto
 *
 * @OA\Schema(
 *     description="Jumlah Bantuan Data For Card",
 *     title="GetJumlahBantuanDto Schema",
 * )
 */
class GetJumlahBantuanDto {

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $penerima;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlah;
}
