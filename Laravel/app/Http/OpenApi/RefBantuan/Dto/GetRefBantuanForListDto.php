<?php

/**
 * Class GetRefBantuanForListDto
 *
 * @OA\Schema(
 *     description="RefBantuan List in Tabular model",
 *     title="GetRefBantuanForListDto Schema",
 * )
 */
class GetRefBantuanForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefBantuanDto")
     * )
     *
     * @var array
     */
    private $items;
}
        