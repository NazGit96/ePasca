<?php

/**
 * Class GetRefJenisBayaranForListDto
 *
 * @OA\Schema(
 *     description="RefJenisBayaran List in Tabular model",
 *     title="GetRefJenisBayaranForListDto Schema",
 * )
 */
class GetRefJenisBayaranForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefJenisBayaranDto")
     * )
     *
     * @var array
     */
    private $items;
}
        