<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/mangsaRumah/getAll",
 *     tags={"MangsaRumah"},
 *     summary="Get all MangsaRumah",
 *     operationId="mangsa-rumah-PagedResultDtoOfMangsaRumahForViewDto",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfMangsaRumahForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

 /**
 * @OA\Get(
 *     path="/api/mangsaRumah/getAllByIdMangsa",
 *     tags={"MangsaRumah"},
 *     summary="Get all MangsaRumah by Id Mangsa",
 *     operationId="mangsa-rumah-by-idMangsa-PagedResultDtoOfMangsaRumahForViewDto",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfMangsaRumahForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/mangsaRumah/getMangsaRumahForEdit",
 *     tags={"MangsaRumah"},
 *     summary="Get MangsaRumah by id",
 *     operationId="mangsa-rumah-GetMangsaRumahForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="MangsaRumah Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetMangsaRumahForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/mangsaRumah/createOrEdit",
 *     tags={"MangsaRumah"},
 *     summary="Create or edit MangsaRumah",
 *     operationId="mangsa-rumah-CreateOrEditMangsaRumahDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditMangsaRumahDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditMangsaRumahDto")
 *     )
 * )
 */

 /**
 * @OA\Delete(
 *     path="/api/mangsaRumah/delete",
 *     tags={"MangsaRumah"},
 *     summary="delete Mangsa Rumah",
 *     operationId="mangsa-rumah-delete",
 *   @OA\Parameter(
 *     name="id",
 *     description="Mangsa Rumah Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputDeleteMangsaRumahDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */
