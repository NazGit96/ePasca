<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/refJenisBayaran/getAll",
 *     tags={"RefJenisBayaran"},
 *     summary="Get all RefJenisBayaran",
 *     operationId="ref-jenis-bayaran-PagedResultDtoOfRefJenisBayaranForViewDto",
 *     @OA\Parameter(
 *     name="filter",
 *     description="Filter records with a string",
 *     in="query",
 *     @OA\Schema(
 *         type="string"
 *        )
 *     ),
 *     @OA\Parameter(
 *     name="filterStatus",
 *     description="Filter records with a integer",
 *     in="query",
 *     @OA\Schema(
 *         type="integer"
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfRefJenisBayaranForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/refJenisBayaran/getRefJenisBayaranForEdit",
 *     tags={"RefJenisBayaran"},
 *     summary="Get RefJenisBayaran by id",
 *     operationId="ref-jenis-bayaran-GetRefJenisBayaranForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="RefJenisBayaran Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetRefJenisBayaranForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/refJenisBayaran/getRefJenisBayaranForDropdown",
 *     tags={"RefJenisBayaran"},
 *     summary="Get all RefJenisBayaran in dropdown list",
 *     operationId="ref-jenis-bayaran-getRefJenisBayaranForDropdown",
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
 *         @OA\JsonContent(ref="#/components/schemas/GetRefJenisBayaranForListDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/refJenisBayaran/createOrEdit",
 *     tags={"RefJenisBayaran"},
 *     summary="Create or edit RefJenisBayaran",
 *     operationId="ref-jenis-bayaran-CreateOrEditRefJenisBayaranDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputCreateJenisBayaranDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditRefJenisBayaranDto")
 *     )
 * )
 */
