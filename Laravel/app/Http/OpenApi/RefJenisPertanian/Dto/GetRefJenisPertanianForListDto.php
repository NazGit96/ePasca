<?php

/**
 * Class GetRefJenisPertanianForListDto
 *
 * @OA\Schema(
 *     description="RefJenisPertanian List in Tabular model",
 *     title="GetRefJenisPertanianForListDto Schema",
 * )
 */
class GetRefJenisPertanianForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefJenisPertanianDto")
     * )
     *
     * @var array
     */
    private $items;
}
        