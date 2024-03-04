<?php

/**
 * Class GetRefJenisBwiForListDto
 *
 * @OA\Schema(
 *     description="RefJenisBwi List in Tabular model",
 *     title="GetRefJenisBwiForListDto Schema",
 * )
 */
class GetRefJenisBwiForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefJenisBwiDto")
     * )
     *
     * @var array
     */
    private $items;
}
        