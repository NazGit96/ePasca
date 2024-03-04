<?php

/**
 * Class GetRefJenisBencanaForListDto
 *
 * @OA\Schema(
 *     description="RefJenisBencana List in Tabular model",
 *     title="GetRefJenisBencanaForListDto Schema",
 * )
 */
class GetRefJenisBencanaForListDto {
    /**
     * @OA\Property(
     *     description="Items in array of object",
     *     title="Items",
     *     @OA\Items(ref="#/components/schemas/RefJenisBencanaDto")
     * )
     *
     * @var array
     */
    private $items;
}
        