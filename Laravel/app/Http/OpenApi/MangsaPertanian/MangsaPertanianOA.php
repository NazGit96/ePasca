<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/mangsaPertanian/getAll",
 *     tags={"MangsaPertanian"},
 *     summary="Get all MangsaPertanian",
 *     operationId="mangsa-pertanian-PagedResultDtoOfMangsaPertanianForViewDto",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfMangsaPertanianForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

 /**
 * @OA\Get(
 *     path="/api/mangsaPertanian/getAllByIdMangsa",
 *     tags={"MangsaPertanian"},
 *     summary="Get all MangsaPertanian by Id Mangsa",
 *     operationId="mangsa-pertanian-by-idMangsa-PagedResultDtoOfMangsaPertanianForViewDto",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfMangsaPertanianForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/mangsaPertanian/getMangsaPertanianForEdit",
 *     tags={"MangsaPertanian"},
 *     summary="Get MangsaPertanian by id",
 *     operationId="mangsa-pertanian-GetMangsaPertanianForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="MangsaPertanian Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetMangsaPertanianForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/mangsaPertanian/createOrEdit",
 *     tags={"MangsaPertanian"},
 *     summary="Create or edit MangsaPertanian",
 *     operationId="mangsa-pertanian-CreateOrEditMangsaPertanianDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditMangsaPertanianDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditMangsaPertanianDto")
 *     )
 * )
 */

 /**
 * @OA\Delete(
 *     path="/api/mangsaPertanian/delete",
 *     tags={"MangsaPertanian"},
 *     summary="delete Mangsa Pertanian",
 *     operationId="mangsa-pertanian-delete",
 *   @OA\Parameter(
 *     name="id",
 *     description="Mangsa Pertanian Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputDeleteMangsaPertanianDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */
