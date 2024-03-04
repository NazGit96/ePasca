<?php

/**
 * Class GetRefPelaksanaForListDto
 *
 * @OA\Schema(
 *     description="RefPelaksana List in Tabular model",
 *     title="GetRefPelaksanaForListDto Schema",
 * )
 */
class GetRefPelaksanaForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefPelaksanaDto")
     * )
     *
     * @var array
     */
    private $items;
}
        