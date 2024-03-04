<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/mangsaAntarabangsa/getAll",
 *     tags={"MangsaAntarabangsa"},
 *     summary="Get all MangsaAntarabangsa",
 *     operationId="mangsa-antarabangsa-PagedResultDtoOfMangsaAntarabangsaForViewDto",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfMangsaAntarabangsaForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

 /**
 * @OA\Get(
 *     path="/api/mangsaAntarabangsa/getAllByIdMangsa",
 *     tags={"MangsaAntarabangsa"},
 *     summary="Get all MangsaAntarabangsa by Id Mangsa",
 *     operationId="mangsa-antarabangsa-by-idMangsa-PagedResultDtoOfMangsaAntarabangsaForViewDto",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfMangsaAntarabangsaForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/mangsaAntarabangsa/getMangsaAntarabangsaForEdit",
 *     tags={"MangsaAntarabangsa"},
 *     summary="Get MangsaAntarabangsa by id",
 *     operationId="mangsa-antarabangsa-GetMangsaAntarabangsaForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="MangsaAntarabangsa Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetMangsaAntarabangsaForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/mangsaAntarabangsa/createOrEdit",
 *     tags={"MangsaAntarabangsa"},
 *     summary="Create or edit MangsaAntarabangsa",
 *     operationId="mangsa-antarabangsa-CreateOrEditMangsaAntarabangsaDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditMangsaAntarabangsaDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditMangsaAntarabangsaDto")
 *     )
 * )
 */

 /**
 * @OA\Delete(
 *     path="/api/mangsaAntarabangsa/delete",
 *     tags={"mangsaAntarabangsa"},
 *     summary="delete Mangsa Antarabangsa",
 *     operationId="mangsa-antarabangsa-delete",
 *   @OA\Parameter(
 *     name="id",
 *     description="Mangsa Antarabangsa Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputDeleteMangsaAntarabangsaDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */
