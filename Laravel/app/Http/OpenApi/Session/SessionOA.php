<?php

namespace app\Http\OpenApi;

 /**
 * @OA\Get(
 *     path="/api/session/getProfil",
 *     tags={"Session"},
 *     summary="Get current login info",
 *     operationId="session-getProfil",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetProfilDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

 /**
 * @OA\Put(
 *     path="/api/session/updateProfil",
 *     tags={"Session"},
 *     summary="Update profil pengguna",
 *     operationId="session-updateProfil",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputProfilDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Edit Profil Input",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/UpdateProfilDto")
 *     )
 * )
 */

 /**
 * @OA\Put(
 *     path="/api/session/changePassword",
 *     tags={"Session"},
 *     summary="Update kata laluan pengguna",
 *     operationId="session-changePassword",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputProfilDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Change Password Input",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/ChangePasswordDto")
 *     )
 * )
 */

   /**
 * @OA\Post(
 *     path="/api/session/uploadGambarProfil",
 *     tags={"Session"},
 *     summary="Store profile image",
 *     operationId="session-uploadGambarProfil",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                  @OA\Property(
 *                      property="image",
 *                      type="string", format="binary"
 *                  )
 *            )
 *         )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputGambarProfil")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured",
 *     )
 * )
 */


