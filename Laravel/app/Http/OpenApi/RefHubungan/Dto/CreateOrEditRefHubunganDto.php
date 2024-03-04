<?php

namespace app\Http\OpenApi;

/**
 * Class CreateOrEditRefHubunganDto
 *
 * @OA\Schema(
 *     title="CreateOrEditRefHubunganDto Schema"
 * )
 */
class CreateOrEditRefHubunganDto
{
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $id;
    
    /**
     * @OA\Property(
     * )
     *
     * @var string
     */
    private $nama_hubungan;
    
    /**
     * @OA\Property(
     * )
     *
     * @var integer
     */
    private $status_hubungan;
    
}
