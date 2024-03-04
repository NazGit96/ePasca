<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/tabungBayaranWaran/getAll",
 *     tags={"TabungBayaranWaran"},
 *     summary="Get all TabungBayaranWaran",
 *     operationId="tabung-bayaran-waran-PagedResultDtoOfTabungBayaranWaranForViewDto",
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
 *     name="filterYearTarikhWaran",
 *     description="Filter records with integer",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfTabungBayaranWaranForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/tabungBayaranWaran/getTabungBayaranWaranForEdit",
 *     tags={"TabungBayaranWaran"},
 *     summary="Get TabungBayaranWaran by id",
 *     operationId="tabung-bayaran-waran-GetTabungBayaranWaranForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="TabungBayaranWaran Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetTabungBayaranWaranForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/tabungBayaranWaran/createOrEdit",
 *     tags={"TabungBayaranWaran"},
 *     summary="Create or edit TabungBayaranWaran",
 *     operationId="tabung-bayaran-waran-InputCreateBayaranWaranDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputCreateBayaranWaranDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/InputCreateBayaranWaranDto")
 *     )
 * )
 */

 /**
 * @OA\Delete(
 *     path="/api/tabungBayaranWaran/delete",
 *     tags={"tabungBayaranWaran"},
 *     summary="delete Bayaran Waran",
 *     operationId="deleteWaran-tabungBayaranWaran",
 *   @OA\Parameter(
 *     name="id",
 *     description="Waran Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputCreateBayaranWaranDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */
