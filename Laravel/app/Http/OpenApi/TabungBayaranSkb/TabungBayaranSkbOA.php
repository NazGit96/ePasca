<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/tabungBayaranSkb/getAll",
 *     tags={"TabungBayaranSkb"},
 *     summary="Get all TabungBayaranSkb",
 *     operationId="tabung-bayaran-skb-PagedResultDtoOfTabungBayaranSkbForViewDto",
 *     @OA\Parameter(
 *     name="filter",
 *     description="Filter records with a string",
 *     in="query",
 *     @OA\Schema(
 *         type="string"
 *        )
 *     ),
 *     @OA\Parameter(
 *     name="filterAgensi",
 *     description="Filter records with a integer",
 *     in="query",
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Parameter(
 *     name="filterTabung",
 *     description="Filter records with a integer",
 *     in="query",
 *     @OA\Schema(
 *         type="integer"
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfTabungBayaranSkbForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/tabungBayaranSkb/getAllSkbForLookupTable",
 *     tags={"TabungBayaranSkb"},
 *     summary="Get all TabungBayaranSkb",
 *     operationId="tabung-bayaran-skb-getAllSkbForLookupTable",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfTabungBayaranSkbForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/tabungBayaranSkb/getTabungBayaranSkbForEdit",
 *     tags={"TabungBayaranSkb"},
 *     summary="Get TabungBayaranSkb by id",
 *     operationId="tabung-bayaran-skb-GetTabungBayaranSkbForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="TabungBayaranSkb Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetTabungBayaranSkbForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/tabungBayaranSkb/createOrEdit",
 *     tags={"TabungBayaranSkb"},
 *     summary="Create or edit TabungBayaranSkb",
 *     operationId="tabung-bayaran-skb-InputCreateBayaranSkbDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputCreateBayaranSkbDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/InputCreateBayaranSkbDto")
 *     )
 * )
 */

 /**
 * @OA\Delete(
 *     path="/api/tabungBayaranSkb/delete",
 *     tags={"TabungBayaranSkb"},
 *     summary="delete Bayaran Skb",
 *     operationId="deleteSkb-TabungBayaranSkb",
 *   @OA\Parameter(
 *     name="id",
 *     description="Skb Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputCreateBayaranSkbDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */
