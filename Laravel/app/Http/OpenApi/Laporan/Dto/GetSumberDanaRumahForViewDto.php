<?php

/**
 * Class GetSumberDanaRumahForViewDto
 *
 * @OA\Schema(
 *     description="Sumber dana list in Tabular model",
 *     title="GetSumberDanaRumahForViewDto Schema",
 * )
 */
class GetSumberDanaRumahForViewDto {

    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/TotalSumberDanaRumahForViewDto")
     * )
     *
     * @var array
     */
    private $sumber_dana;
}
