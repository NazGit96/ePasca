<?php

/**
 * Class TotalMangsaBencanaByNegeriForViewDto
 *
 * @OA\Schema(
 *     description="Jumlah Mangsa dan Bencana By Negeri",
 *     title="TotalMangsaBencanaByNegeriForViewDto Schema",
 * )
 */
class TotalMangsaBencanaByNegeriForViewDto {

     /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/GetTotalMangsaBencanaByNegeriDto")
     * )
     *
     * @var array
     */
    private $items;
}
