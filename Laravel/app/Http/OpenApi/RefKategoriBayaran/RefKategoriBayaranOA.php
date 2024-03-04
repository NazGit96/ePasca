<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/refKategoriBayaran/getAll",
 *     tags={"RefKategoriBayaran"},
 *     summary="Get all RefKategoriBayaran",
 *     operationId="ref-kategori-bayaran-PagedResultDtoOfRefKategoriBayaranForViewDto",
 *     @OA\Parameter(
 *     name="filter",
 *     description="Filter records with a string",
 *     in="query",
 *     @OA\Schema(
 *         type="string"
 *        )
 *     ),
 *     @OA\Parameter(
 *     name="sorting",
 *     description="Specify column name and sorting value i.e: `column_name asc` or `column_name desc`",
 *     in="query",
 *     @OA\Schema(
 *         type="string"
 *        )
 *     ),
 *     @OA\Parameter(
 *     name="skipCount",
 *     description="Skip n-value of a record",
 *     in="query",
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Parameter(
 *     name="maxResultCount",
 *     description="Maximum records per page. Default value is 10",
 *     in="query",
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfRefKategoriBayaranForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/refKategoriBayaran/getRefKategoriBayaranForEdit",
 *     tags={"RefKategoriBayaran"},
 *     summary="Get RefKategoriBayaran by id",
 *     operationId="ref-kategori-bayaran-GetRefKategoriBayaranForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="RefKategoriBayaran Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetRefKategoriBayaranForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/refKategoriBayaran/getRefKategoriBayaranForDropdown",
 *     tags={"RefKategoriBayaran"},
 *     summary="Get all RefKategoriBayaran in dropdown list",
 *     operationId="ref-kategori-bayaran-getRefKategoriBayaranForDropdown",
 *     @OA\Parameter(
 *     name="filter",
 *     description="Filter records with a string",
 *     in="query",
 *     @OA\Schema(
 *         type="string"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetRefKategoriBayaranForListDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/refKategoriBayaran/createOrEdit",
 *     tags={"RefKategoriBayaran"},
 *     summary="Create or edit RefKategoriBayaran",
 *     operationId="ref-kategori-bayaran-CreateOrEditRefKategoriBayaranDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditRefKategoriBayaranDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditRefKategoriBayaranDto")
 *     )
 * )
 */
