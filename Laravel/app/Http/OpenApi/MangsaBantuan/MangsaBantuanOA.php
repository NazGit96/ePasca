<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/mangsaBantuan/getAll",
 *     tags={"MangsaBantuan"},
 *     summary="Get all MangsaBantuan",
 *     operationId="mangsa-bantuan-PagedResultDtoOfMangsaBantuanForViewDto",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfMangsaBantuanForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

 /**
 * @OA\Get(
 *     path="/api/mangsaBantuan/getAllByIdMangsa",
 *     tags={"MangsaBantuan"},
 *     summary="Get all MangsaBantuan by Id Mangsa",
 *     operationId="mangsa-bantuan-by-idMangsa-PagedResultDtoOfMangsaBantuanForViewDto",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfMangsaBantuanForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/mangsaBantuan/getMangsaBantuanForEdit",
 *     tags={"MangsaBantuan"},
 *     summary="Get MangsaBantuan by id",
 *     operationId="mangsa-bantuan-GetMangsaBantuanForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="MangsaBantuan Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetMangsaBantuanForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/mangsaBantuan/createOrEdit",
 *     tags={"MangsaBantuan"},
 *     summary="Create or edit MangsaBantuan",
 *     operationId="mangsa-bantuan-CreateOrEditMangsaBantuanDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditMangsaBantuanDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditMangsaBantuanDto")
 *     )
 * )
 */

 /**
 * @OA\Delete(
 *     path="/api/mangsaBantuan/delete",
 *     tags={"MangsaBantuan"},
 *     summary="delete Mangsa Bantuan Lain",
 *     operationId="mangsa-bantuan-lain-delete",
 *     @OA\Parameter(
 *     name="id",
 *     description="Mangsa Bantuan Lain Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputDeleteMangsaBantuanLainDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */
