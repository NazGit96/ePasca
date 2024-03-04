<?php

/**
 * Class GetBelanjaTanggunganByTabungForViewDto
 *
 * @OA\Schema(
 *     description="Total Belanja and Tanggungan by Tabung in Tabular model",
 *     title="GetBelanjaTanggunganByTabungForViewDto Schema",
 * )
 */
class GetBelanjaTanggunganByTabungForViewDto{

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
