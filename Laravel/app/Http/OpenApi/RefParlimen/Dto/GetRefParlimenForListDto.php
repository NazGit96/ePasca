<?php

/**
 * Class GetRefParlimenForListDto
 *
 * @OA\Schema(
 *     description="RefParlimen List in Tabular model",
 *     title="GetRefParlimenForListDto Schema",
 * )
 */
class GetRefParlimenForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefParlimenDto")
     * )
     *
     * @var array
     */
    private $items;
}
        