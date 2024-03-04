<?php

/**
 * Class GetTotalBantuanForViewDto
 *
 * @OA\Schema(
 *     description="Total Bantuan by Jenis Bantuan in Tabular model",
 *     title="GetTotalBantuanForViewDto Schema",
 * )
 */
class GetTotalBantuanForViewDto{

    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/GetTotalBantuanByJenisBantuanDto")
     * )
     *
     * @var array
     */
    private $bantuan;

}
