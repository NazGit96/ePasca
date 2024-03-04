<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/tabungBayaranWaranStatus/getAll",
 *     tags={"TabungBayaranWaranStatus"},
 *     summary="Get all TabungBayaranWaranStatus",
 *     operationId="tabung-bayaran-waran-status-PagedResultDtoOfTabungBayaranWaranStatusForViewDto",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfTabungBayaranWaranStatusForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/tabungBayaranWaranStatus/getTabungKelulusanAmbilanForEdit",
 *     tags={"TabungBayaranWaranStatus"},
 *     summary="Get TabungBayaranWaranStatus by id",
 *     operationId="tabung-bayaran-waran-status-GetTabungBayaranWaranStatusForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="TabungBayaranWaranStatus Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetTabungBayaranWaranStatusForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/tabungBayaranWaranStatus/createOrEdit",
 *     tags={"TabungBayaranWaranStatus"},
 *     summary="Create or edit TabungBayaranWaranStatus",
 *     operationId="tabung-bayaran-waran-status-CreateOrEditTabungBayaranWaranStatusDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditTabungBayaranWaranStatusDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditTabungBayaranWaranStatusDto")
 *     )
 * )
 */
