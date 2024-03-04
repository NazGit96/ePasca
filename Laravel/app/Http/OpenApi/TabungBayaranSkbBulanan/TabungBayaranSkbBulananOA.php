<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/tabungBayaranSkbBulanan/getAll",
 *     tags={"TabungBayaranSkbBulanan"},
 *     summary="Get all TabungBayaranSkbBulanan",
 *     operationId="tabung-bayaran-skb-bulanan-PagedResultDtoOfTabungBayaranSkbBulananForViewDto",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfTabungBayaranSkbBulananForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/tabungBayaranSkbBulanan/getAllBulananbyIdSkb",
 *     tags={"TabungBayaranSkbBulanan"},
 *     summary="Get all TabungBayaranSkbBulanan by IdBayaranSkb",
 *     operationId="tabung-bayaran-skb-bulanan-by-IdBayaranSkb-PagedResultDtoOfTabungBayaranSkbBulananForViewDto",
 *     @OA\Parameter(
 *     name="filter",
 *     description="Filter records with a string",
 *     in="query",
 *     @OA\Schema(
 *         type="string"
 *        )
 *     ),
 *     @OA\Parameter(
 *     name="filterSkb",
 *     description="Filter Id Skb records with a integer",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfTabungBayaranSkbBulananForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/tabungBayaranSkbBulanan/getTabungBayaranSkbBulananForEdit",
 *     tags={"TabungBayaranSkbBulanan"},
 *     summary="Get TabungBayaranSkbBulanan by id",
 *     operationId="tabung-bayaran-skb-bulanan-GetTabungBayaranSkbBulananForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="TabungBayaranSkbBulanan Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetTabungBayaranSkbBulananForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/tabungBayaranSkbBulanan/createOrEdit",
 *     tags={"TabungBayaranSkbBulanan"},
 *     summary="Create or edit TabungBayaranSkbBulanan",
 *     operationId="tabung-bayaran-skb-bulanan-CreateOrEditTabungBayaranSkbBulananDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputCreateSkbBulananDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditTabungBayaranSkbBulananDto")
 *     )
 * )
 */

/**
 * @OA\Delete(
 *     path="/api/tabungBayaranSkbBulanan/delete",
 *     tags={"TabungBayaranSkbBulanan"},
 *     summary="delete Bayaran Skb Bulanan",
 *     operationId="deleteSkbBulanan-TabungBayaranSkbBulanan",
 *   @OA\Parameter(
 *     name="id",
 *     description="Skb Bulanan Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputCreateSkbBulananDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */
