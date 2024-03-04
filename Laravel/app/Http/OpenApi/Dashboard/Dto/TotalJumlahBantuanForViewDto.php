<?php

/**
 * Class TotalJumlahBantuanForViewDto
 *
 * @OA\Schema(
 *     description="Jumlah Bantuan Data For Card",
 *     title="TotalJumlahBantuanForViewDto Schema",
 * )
 */
class TotalJumlahBantuanForViewDto {

    /**
     * @OA\Property(
     *     title="jumlahMangsa Model",
     *     ref="#/components/schemas/GetJumlahBantuanDto"
     * )
     *
     * @var object
     */
    private $jumlahMangsa;

    /**
     * @OA\Property(
     *     title="bantuanBwi Model",
     *     ref="#/components/schemas/GetJumlahBantuanDto"
     * )
     *
     * @var object
     */
    private $bantuanBwi;

    /**
     * @OA\Property(
     *     title="bantuanPinjaman Model",
     *     ref="#/components/schemas/GetJumlahBantuanDto"
     * )
     *
     * @var object
     */
    private $bantuanPinjaman;

    /**
     * @OA\Property(
     *     title="bantuanAntarabangsa Model",
     *     ref="#/components/schemas/GetJumlahBantuanDto"
     * )
     *
     * @var object
     */
    private $bantuanAntarabangsa;

    /**
     * @OA\Property(
     *     title="bantuanPertanian Model",
     *     ref="#/components/schemas/GetJumlahBantuanDto"
     * )
     *
     * @var object
     */
    private $bantuanPertanian;

    /**
     * @OA\Property(
     *     title="bantuanLain Model",
     *     ref="#/components/schemas/GetJumlahBantuanDto"
     * )
     *
     * @var object
     */
    private $bantuanLain;

    /**
     * @OA\Property(
     *     title="bantuanRumahBaikPulih Model",
     *     ref="#/components/schemas/GetJumlahBantuanDto"
     * )
     *
     * @var object
     */
    private $bantuanRumahBaikPulih;

    /**
     * @OA\Property(
     *     title="bantuanRumahKekal Model",
     *     ref="#/components/schemas/GetJumlahBantuanDto"
     * )
     *
     * @var object
     */
    private $bantuanRumahKekal;
}
