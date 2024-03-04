<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/tabungBayaranWaranBulanan/getAll",
 *     tags={"TabungBayaranWaranBulanan"},
 *     summary="Get all TabungBayaranWaranBulanan",
 *     operationId="tabung-bayaran-waran-bulanan-PagedResultDtoOfTabungBayaranWaranBulananForViewDto",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfTabungBayaranWaranBulananForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/tabungBayaranWaranBulanan/getAllBulananbyIdWaran",
 *     tags={"TabungBayaranWaranBulanan"},
 *     summary="Get all TabungBayaranWaranBulanan by IdBayaranWaran",
 *     operationId="tabung-bayaran-waran-bulanan-by-IdBayaranWaran-PagedResultDtoOfTabungBayaranWaranBulananForViewDto",
 *     @OA\Parameter(
 *     name="filter",
 *     description="Filter records with a string",
 *     in="query",
 *     @OA\Schema(
 *         type="string"
 *        )
 *     ),
 *     @OA\Parameter(
 *     name="filterWaran",
 *     description="Filter Id Waran records with a integer",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfTabungBayaranWaranBulananForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/tabungBayaranWaranBulanan/getTabungBayaranWaranBulananForEdit",
 *     tags={"TabungBayaranWaranBulanan"},
 *     summary="Get TabungBayaranWaranBulanan by id",
 *     operationId="tabung-bayaran-waran-bulanan-GetTabungBayaranWaranBulananForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="TabungBayaranWaranBulanan Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetTabungBayaranWaranBulananForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/tabungBayaranWaranBulanan/createOrEdit",
 *     tags={"TabungBayaranWaranBulanan"},
 *     summary="Create or edit TabungBayaranWaranBulanan",
 *     operationId="tabung-bayaran-waran-bulanan-CreateOrEditTabungBayaranWaranBulananDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputCreateWaranBulananDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditTabungBayaranWaranBulananDto")
 *     )
 * )
 */

/**
 * @OA\Delete(
 *     path="/api/tabungBayaranWaranBulanan/delete",
 *     tags={"tabungBayaranWaranBulanan"},
 *     summary="delete Bayaran Skb Bulanan",
 *     operationId="deleteSkbBulanan-tabungBayaranWaranBulanan",
 *   @OA\Parameter(
 *     name="id",
 *     description="Waran Bulanan Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputCreateWaranBulananDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */
