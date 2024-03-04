<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/mangsaWangIhsan/getAll",
 *     tags={"MangsaWangIhsan"},
 *     summary="Get all MangsaWangIhsan",
 *     operationId="mangsa-wang-ihsan-PagedResultDtoOfMangsaWangIhsanForViewDto",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfMangsaWangIhsanForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

 /**
 * @OA\Get(
 *     path="/api/mangsaWangIhsan/getAllByIdMangsa",
 *     tags={"MangsaWangIhsan"},
 *     summary="Get all MangsaWangIhsan by Id Mangsa",
 *     operationId="mangsa-wang-ihsan-by-idMangsa-getAllByIdMangsa",
 *     @OA\Parameter(
 *     name="idMangsa",
 *     description="Filter by Id Mangsa",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfMangsaWangIhsanForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

 /**
 * @OA\Get(
 *     path="/api/mangsaWangIhsan/getAllMangsaByBencanaAndJenisBwi",
 *     tags={"MangsaWangIhsan"},
 *     summary="Get all MangsaWangIhsan by Id Bencana and Jenis Bwi",
 *     operationId="mangsa-wang-ihsan-by-idMangsa-getAllMangsaByBencanaAndJenisBwi",
 *     @OA\Parameter(
 *     name="filter",
 *     description="Filter records with a string",
 *     in="query",
 *     @OA\Schema(
 *         type="string"
 *        )
 *     ),
 *     @OA\Parameter(
 *     name="filterBencana",
 *     description="Filter records with a integer",
 *     in="query",
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Parameter(
 *     name="filterJenisBwi",
 *     description="Filter records with a integer",
 *     in="query",
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Parameter(
 *     name="filteDaerah",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfMangsaWangIhsanForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/mangsaWangIhsan/getTotalBwiMangsaByIdBencana",
 *     tags={"MangsaWangIhsan"},
 *     summary="Get Total MangsaWangIhsan by id Bencana",
 *     operationId="mangsa-wang-ihsan-getTotalBwiMangsaByIdBencana",
 *     @OA\Parameter(
 *     name="id_bencana",
 *     description="MangsaWangIhsan Id Bencana",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Parameter(
 *     name="id_jenis_bwi",
 *     description="MangsaWangIhsan Id Jenis Bwi",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Parameter(
 *     name="id_daerah",
 *     description="MangsaWangIhsan Id Jenis Bwi",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/InputTotalWangIhsanDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/mangsaWangIhsan/getMangsaWangIhsanForEdit",
 *     tags={"MangsaWangIhsan"},
 *     summary="Get MangsaWangIhsan by id",
 *     operationId="mangsa-wang-ihsan-GetMangsaWangIhsanForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="MangsaWangIhsan Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetMangsaWangIhsanForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/mangsaWangIhsan/createOrEdit",
 *     tags={"MangsaWangIhsan"},
 *     summary="Create or edit MangsaWangIhsan",
 *     operationId="mangsa-wang-ihsan-CreateOrEditMangsaWangIhsanDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditMangsaWangIhsanDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditMangsaWangIhsanDto")
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/mangsaWangIhsan/multipleCreateMangsaBwi",
 *     tags={"MangsaWangIhsan"},
 *     summary="Create or edit multipleCreateMangsaBwi",
 *     operationId="mangsa-wang-ihsan-multipleCreateMangsaBwi",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputCreateMangsaBwiDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/InputCreateMultipleWangIhsanDto")
 *     )
 * )
 */

 /**
 * @OA\Delete(
 *     path="/api/mangsaWangIhsan/delete",
 *     tags={"mangsaWangIhsan"},
 *     summary="delete Mangsa Wang Ihsan",
 *     operationId="mangsa-wang-ihsan-delete",
 *   @OA\Parameter(
 *     name="id",
 *     description="Mangsa Wang Ihsan Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputCreateMangsaBwiDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */
