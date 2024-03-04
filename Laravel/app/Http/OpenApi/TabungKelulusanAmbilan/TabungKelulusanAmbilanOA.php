<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/tabungKelulusanAmbilan/getAll",
 *     tags={"TabungKelulusanAmbilan"},
 *     summary="Get all TabungKelulusanAmbilan",
 *     operationId="tabung-kelulusan-ambilan-PagedResultDtoOfTabungKelulusanAmbilanForViewDto",
 *     @OA\Parameter(
 *     name="filter",
 *     description="Filter records with a string",
 *     in="query",
 *     @OA\Schema(
 *         type="string"
 *        )
 *     ),
 *     @OA\Parameter(
 *     name="filterYear",
 *     description="Filter records with a integer",
 *     in="query",
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Parameter(
 *     name="filterIdKelulusan",
 *     description="Filter records with a string",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfTabungKelulusanAmbilanForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/tabungKelulusanAmbilan/getTabungKelulusanAmbilanForEdit",
 *     tags={"TabungKelulusanAmbilan"},
 *     summary="Get TabungKelulusanAmbilan by id",
 *     operationId="tabung-kelulusan-ambilan-GetTabungKelulusanAmbilanForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="TabungKelulusanAmbilan Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetTabungKelulusanAmbilanForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/tabungKelulusanAmbilan/createOrEdit",
 *     tags={"TabungKelulusanAmbilan"},
 *     summary="Create or edit TabungKelulusanAmbilan",
 *     operationId="tabung-kelulusan-ambilan-CreateOrEditTabungKelulusanAmbilanDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputCreateOrEditTabungKelulusanAmbilanDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditTabungKelulusanAmbilanDto")
 *     )
 * )
 */
