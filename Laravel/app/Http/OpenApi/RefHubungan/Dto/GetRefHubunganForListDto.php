<?php

/**
 * Class GetRefHubunganForListDto
 *
 * @OA\Schema(
 *     description="RefHubungan List in Tabular model",
 *     title="GetRefHubunganForListDto Schema",
 * )
 */
class GetRefHubunganForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefHubunganDto")
     * )
     *
     * @var array
     */
    private $items;
}
        