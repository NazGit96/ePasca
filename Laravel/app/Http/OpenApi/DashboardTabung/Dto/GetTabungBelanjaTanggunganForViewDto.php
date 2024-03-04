<?php

/**
 * Class GetTabungBelanjaTanggunganForViewDto
 *
 * @OA\Schema(
 *     description="Total Belanja and Tanggungan by Tabung in Tabular model",
 *     title="GetTabungBelanjaTanggunganForViewDto Schema",
 * )
 */
class GetTabungBelanjaTanggunganForViewDto{

    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/GetBelanjaTanggunganByTabungForViewDto")
     * )
     *
     * @var array
     */
    private $tabung;

}
