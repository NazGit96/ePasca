<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/refPinjamanPerniagaan/getAll",
 *     tags={"RefPinjamanPerniagaan"},
 *     summary="Get all RefPinjamanPerniagaan",
 *     operationId="ref-pinjaman-perniagaan-PagedResultDtoOfRefPinjamanPerniagaanForViewDto",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfRefPinjamanPerniagaanForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/refPinjamanPerniagaan/getRefPinjamanPerniagaanForEdit",
 *     tags={"RefPinjamanPerniagaan"},
 *     summary="Get RefPinjamanPerniagaan by id",
 *     operationId="ref-pinjaman-perniagaan-GetRefPinjamanPerniagaanForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="RefPinjamanPerniagaan Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetRefPinjamanPerniagaanForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/refPinjamanPerniagaan/getRefPinjamanPerniagaanForDropdown",
 *     tags={"RefPinjamanPerniagaan"},
 *     summary="Get all RefPinjamanPerniagaan in dropdown list",
 *     operationId="ref-pinjaman-perniagaan-getRefPinjamanPerniagaanForDropdown",
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
 *         @OA\JsonContent(ref="#/components/schemas/GetRefPinjamanPerniagaanForListDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/refPinjamanPerniagaan/createOrEdit",
 *     tags={"RefPinjamanPerniagaan"},
 *     summary="Create or edit RefPinjamanPerniagaan",
 *     operationId="ref-pinjaman-perniagaan-CreateOrEditRefPinjamanPerniagaanDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputCreatePinjamanPerniagaanDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditRefPinjamanPerniagaanDto")
 *     )
 * )
 */
