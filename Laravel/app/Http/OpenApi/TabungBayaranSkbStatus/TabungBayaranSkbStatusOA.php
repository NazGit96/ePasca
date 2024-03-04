<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/tabungBayaranSkbStatus/getAll",
 *     tags={"TabungBayaranSkbStatus"},
 *     summary="Get all TabungBayaranSkbStatus",
 *     operationId="tabung-bayaran-skb-status-PagedResultDtoOfTabungBayaranSkbStatusForViewDto",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfTabungBayaranSkbStatusForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/tabungBayaranSkbStatus/getTabungKelulusanAmbilanForEdit",
 *     tags={"TabungBayaranSkbStatus"},
 *     summary="Get TabungBayaranSkbStatus by id",
 *     operationId="tabung-bayaran-skb-status-GetTabungBayaranSkbStatusForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="TabungBayaranSkbStatus Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetTabungBayaranSkbStatusForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/tabungBayaranSkbStatus/createOrEdit",
 *     tags={"TabungBayaranSkbStatus"},
 *     summary="Create or edit TabungBayaranSkbStatus",
 *     operationId="tabung-bayaran-skb-status-CreateOrEditTabungBayaranSkbStatusDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditTabungBayaranSkbStatusDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditTabungBayaranSkbStatusDto")
 *     )
 * )
 */
