<?php

/**
 * Class TotalBantuanByNegeriForViewDto
 *
 * @OA\Schema(
 *     description="Jumlah Bantuan By Negeri",
 *     title="TotalBantuanByNegeriForViewDto Schema",
 * )
 */
class TotalBantuanByNegeriForViewDto {

     /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/GetTotalBantuanByNegeriDto")
     * )
     *
     * @var array
     */
    private $items;
}
