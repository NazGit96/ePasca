<?php

namespace app\Http\OpenApi;

/**
 * Class UpdateProfilDto
 *
 * @OA\Schema(
 *     title="UpdateProfilDto Schema"
 * )
 */
class UpdateProfilDto
{
    /**
     * @OA\Property(
     *     title="Pengguna Profil Model",
     *     ref="#/components/schemas/PenggunaProfilDto"
     * )
     *
     * @var object
     */
    private $pengguna;
}
