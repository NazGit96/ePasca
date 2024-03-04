<?php

/**
 * Class GetRefKategoriBayaranForListDto
 *
 * @OA\Schema(
 *     description="RefKategoriBayaran List in Tabular model",
 *     title="GetRefKategoriBayaranForListDto Schema",
 * )
 */
class GetRefKategoriBayaranForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefKategoriBayaranDto")
     * )
     *
     * @var array
     */
    private $items;
}
        