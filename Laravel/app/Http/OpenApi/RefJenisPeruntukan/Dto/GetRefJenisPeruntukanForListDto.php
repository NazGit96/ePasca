<?php

/**
 * Class GetRefJenisPeruntukanForListDto
 *
 * @OA\Schema(
 *     description="RefJenisPeruntukan List in Tabular model",
 *     title="GetRefJenisPeruntukanForListDto Schema",
 * )
 */
class GetRefJenisPeruntukanForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefJenisPeruntukanDto")
     * )
     *
     * @var array
     */
    private $items;
}
        