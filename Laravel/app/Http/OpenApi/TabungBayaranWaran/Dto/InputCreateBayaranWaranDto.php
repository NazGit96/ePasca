<?php

namespace app\Http\OpenApi;

/**
 * Class InputCreateBayaranWaranDto
 *
 * @OA\Schema(
 *     title="InputCreateBayaranWaranDto Schema"
 * )
 */
class InputCreateBayaranWaranDto
{

    /**
     * @OA\Property(
     *     title="Mangsa Model",
     *     ref="#/components/schemas/CreateOrEditTabungBayaranWaranDto"
     * )
     *
     * @var object
     */
    private $waran;

    /**
     * @OA\Property(
     *     description="Array of kluster object",
     *     title="NgoKluster Model",
     *     @OA\Items(ref="#/components/schemas/InputWaranBulananDto")
     * )
     *
     * @var array
     */
    private $waranBulanan;

     /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $catatan;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $changeStatus;


}
