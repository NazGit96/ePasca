<?php

namespace app\Http\OpenApi;

/**
 * Class InputCreateBayaranSkbDto
 *
 * @OA\Schema(
 *     title="InputCreateBayaranSkbDto Schema"
 * )
 */
class InputCreateBayaranSkbDto
{

    /**
     * @OA\Property(
     *     title="Mangsa Model",
     *     ref="#/components/schemas/CreateOrEditTabungBayaranSkbDto"
     * )
     *
     * @var object
     */
    private $skb;

    /**
     * @OA\Property(
     *     description="Array of kluster object",
     *     title="NgoKluster Model",
     *     @OA\Items(ref="#/components/schemas/InputSkbBulananDto")
     * )
     *
     * @var array
     */
    private $skbBulanan;

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
