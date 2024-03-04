<?php

namespace app\Http\OpenApi;

/**
 * Class GetBelanjaTabungKelulusanDto
 *
 * @OA\Schema(
 *     title="GetBelanjaTabungKelulusanDto Schema"
 * )
 */
class GetBelanjaTabungKelulusanDto
{

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $belanjaSemasa;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $belanjaSebelum;

    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $jumlahBelanja;

}
