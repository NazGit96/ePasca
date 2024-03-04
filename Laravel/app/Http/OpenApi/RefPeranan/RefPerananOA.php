<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/refPeranan/getAll",
 *     tags={"RefPeranan"},
 *     summary="Get all RefPeranan",
 *     operationId="ref-peranan-PagedResultDtoOfRefPerananForViewDto",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfRefPerananForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/refPeranan/getRefPerananForEdit",
 *     tags={"RefPeranan"},
 *     summary="Get RefPeranan by id",
 *     operationId="ref-peranan-GetRefPerananForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="RefPeranan Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetRefPerananForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/refPeranan/getRefPerananForDropdown",
 *     tags={"RefPeranan"},
 *     summary="Get all RefPeranan in dropdown list",
 *     operationId="ref-peranan-getRefPerananForDropdown",
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
 *         @OA\JsonContent(ref="#/components/schemas/GetRefPerananForListDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/refPeranan/createOrEdit",
 *     tags={"RefPeranan"},
 *     summary="Create or edit RefPeranan",
 *     operationId="ref-peranan-CreateOrEditRefPerananDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputRefPerananDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditRefPerananDto")
 *     )
 * )
 */

 /**
 * @OA\Get(
 *     path="/api/refPeranan/getAllRefCapaian",
 *     tags={"RefPeranan"},
 *     summary="Get all RefCapaian in list",
 *     operationId="ref-peranan-getAllRefCapaian",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetAllRefCapaianDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */
