<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/tabungPeruntukan/getAll",
 *     tags={"TabungPeruntukan"},
 *     summary="Get all TabungPeruntukan",
 *     operationId="tabung-peruntukan-PagedResultDtoOfTabungPeruntukanForViewDto",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfTabungPeruntukanForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

 /**
 * @OA\Get(
 *     path="/api/tabungPeruntukan/getPeruntukanByIdTabung",
 *     tags={"TabungPeruntukan"},
 *     summary="Get all TabungPeruntukan by Id Tabung",
 *     operationId="tabung-peruntukan-by-idTabung-PagedResultDtoOfTabungPeruntukanForViewDto",
 *     @OA\Parameter(
 *     name="idTabung",
 *     description="Filter by Id Tabung",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfTabungPeruntukanForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/tabungPeruntukan/getTabungPeruntukanForEdit",
 *     tags={"TabungPeruntukan"},
 *     summary="Get TabungPeruntukan by id",
 *     operationId="tabung-peruntukan-GetTabungPeruntukanForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="TabungPeruntukan Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetTabungPeruntukanForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/tabungPeruntukan/createOrEdit",
 *     tags={"TabungPeruntukan"},
 *     summary="Create or edit TabungPeruntukan",
 *     operationId="tabung-peruntukan-CreateOrEditTabungPeruntukanDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputCreateEditTabungPeruntukanDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditTabungPeruntukanDto")
 *     )
 * )
 */

/**
 * @OA\Delete(
 *     path="/api/tabungPeruntukan/delete",
 *     tags={"TabungPeruntukan"},
 *     summary="delete Peruntukan",
 *     operationId="deletePeruntukan",
 *   @OA\Parameter(
 *     name="id",
 *     description="Peruntukan Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputCreateEditTabungPeruntukanDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */
