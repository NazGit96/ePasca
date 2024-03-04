<?php

namespace app\Http\OpenApi;

/**
 * @OA\Post(
 *     path="/api/file/uploadTempImage",
 *     tags={"File"},
 *     summary="Store image into temporary folder and get its temp url",
 *     operationId="file-uploadTempImage",
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
 *         @OA\JsonContent(ref="#/components/schemas/OutputFileUpload")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured",
 *     )
 * )
 */
