<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/dashboardTabung/getTotalTabungCard",
 *     tags={"DashboardTabung"},
 *     summary="Get Total by Tabung",
 *     operationId="tabung-getTotalTabungCard",
 *     @OA\Parameter(
 *     name="id_tabung",
 *     description="Filter records with a string",
 *     in="query",
 *     @OA\Schema(
 *         type="number"
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
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetTotalByTabungForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/dashboardTabung/getTotalBayaranTerusByMonth",
 *     tags={"DashboardTabung"},
 *     summary="Get Total Bayaran Terus by Tabung",
 *     operationId="tabung-getTotalBayaranTerusByMonth",
 *     @OA\Parameter(
 *     name="filterTabung",
 *     description="Filter records with a string",
 *     in="query",
 *     @OA\Schema(
 *         type="number"
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
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/TotalBayaranTerusByMonth")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

 /**
 * @OA\Get(
 *     path="/api/dashboardTabung/getTotalSkbByMonth",
 *     tags={"DashboardTabung"},
 *     summary="Get Total SKB Tabung by Month",
 *     operationId="tabung-getTotalSkbByMonth",
 *     @OA\Parameter(
 *     name="filterTabung",
 *     description="Filter records with a string",
 *     in="query",
 *     @OA\Schema(
 *         type="number"
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
 *     name="filterFromDate",
 *     description="Filter records with string",
 *     in="query",
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Parameter(
 *     name="filterToDate",
 *     description="Filter records with string",
 *     in="query",
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/TotalSkbByMonth")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

 /**
 * @OA\Get(
 *     path="/api/dashboardTabung/getBelanjaTanggunganByTabung",
 *     tags={"DashboardTabung"},
 *     summary="Get Total Belanja and Tanggungan by Tabung",
 *     operationId="tabung-getBelanjaTanggunganByTabung",
 *     @OA\Parameter(
 *     name="id_tabung",
 *     description="Filter records with a string",
 *     in="query",
 *     @OA\Schema(
 *         type="number"
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
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetTabungBelanjaTanggunganForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */
