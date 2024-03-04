<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/tabungBayaranTerus/getAll",
 *     tags={"TabungBayaranTerus"},
 *     summary="Get all TabungBayaranTerus",
 *     operationId="tabung-bayaran-terus-PagedResultDtoOfTabungBayaranTerusForViewDto",
 *     @OA\Parameter(
 *     name="filter",
 *     description="Filter records with a string",
 *     in="query",
 *     @OA\Schema(
 *         type="string"
 *        )
 *     ),
 *     @OA\Parameter(
 *     name="filterFromDate",
 *     description="Filter records with string",
 *     in="query",
 *     @OA\Schema(
 *         type="string"
 *        )
 *     ),
 *     @OA\Parameter(
 *     name="filterToDate",
 *     description="Filter records with string",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfTabungBayaranTerusForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

 /**
 * @OA\Get(
 *     path="/api/tabungBayaranTerus/getAllBayaranTerusLookupTable",
 *     tags={"TabungBayaranTerus"},
 *     summary="Get all TabungBayaranTerus",
 *     operationId="tabung-bayaran-terus-getAllBayaranTerusLookupTable",
 *     @OA\Parameter(
 *     name="filter",
 *     description="Filter records with a string",
 *     in="query",
 *     @OA\Schema(
 *         type="string"
 *        )
 *     ),
 *     @OA\Parameter(
 *     name="filterIdTabungKelulusan",
 *     description="Filter records with a string",
 *     in="query",
 *     @OA\Schema(
 *         type="number"
 *        )
 *     ),
 *     @OA\Parameter(
 *     name="filterIdBencana",
 *     description="Filter records with a string",
 *     in="query",
 *     @OA\Schema(
 *         type="number"
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfBayaranTerusLookupDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/tabungBayaranTerus/getTabungBayaranTerusForEdit",
 *     tags={"TabungBayaranTerus"},
 *     summary="Get TabungBayaranTerus by id",
 *     operationId="tabung-bayaran-terus-GetTabungBayaranTerusForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="TabungBayaranTerus Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetTabungBayaranTerusForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/tabungBayaranTerus/createOrEdit",
 *     tags={"TabungBayaranTerus"},
 *     summary="Create or edit TabungBayaranTerus",
 *     operationId="tabung-bayaran-terus-CreateOrEditTabungBayaranTerusDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputCreateBayaranTerusDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditTabungBayaranTerusDto")
 *     )
 * )
 */

/**
 * @OA\Delete(
 *     path="/api/tabungBayaranTerus/delete",
 *     tags={"TabungBayaranTerus"},
 *     summary="delete Bayaran Terus-TabungBayaranTerus",
 *     operationId="deleteBayaranTerus-TabungBayaranTerus",
 *   @OA\Parameter(
 *     name="id",
 *     description="Bayaran Terus Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputCreateBayaranTerusDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */
