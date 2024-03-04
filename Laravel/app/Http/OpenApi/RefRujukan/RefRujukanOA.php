<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/refRujukan/getAll",
 *     tags={"RefRujukan"},
 *     summary="Get all RefRujukan",
 *     operationId="ref-rujukan-PagedResultDtoOfRefRujukanForViewDto",
 *     @OA\Parameter(
 *     name="filter",
 *     description="Filter records with a string",
 *     in="query",
 *     @OA\Schema(
 *         type="string"
 *        )
 *     ),
 *     @OA\Parameter(
 *     name="filterStatus",
 *     description="Filter records with integer",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfRefRujukanForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/refRujukan/getRefRujukanForEdit",
 *     tags={"RefRujukan"},
 *     summary="Get RefRujukan by id",
 *     operationId="ref-rujukan-GetRefRujukanForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="RefRujukan Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetRefRujukanForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/refRujukan/createOrEdit",
 *     tags={"RefRujukan"},
 *     summary="Create or edit RefRujukan",
 *     operationId="ref-rujukan-CreateOrEditRefRujukanDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditRefRujukanDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditRefRujukanDto")
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/refRujukan/uploadFail",
 *     tags={"RefRujukan"},
 *     summary="Store Rujukan fail",
 *     operationId="ref-rujukan-uploadFail",
 *     @OA\RequestBody(
 *         @OA\MediaType(
 *             mediaType="multipart/form-data",
 *             @OA\Schema(
 *                  @OA\Property(
 *                      property="fail",
 *                      type="string", format="binary"
 *                  )
 *            )
 *         )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputFail")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured",
 *     )
 * )
 */
