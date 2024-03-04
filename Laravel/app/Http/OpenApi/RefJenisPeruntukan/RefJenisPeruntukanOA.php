<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/refJenisPeruntukan/getAll",
 *     tags={"RefJenisPeruntukan"},
 *     summary="Get all RefJenisPeruntukan",
 *     operationId="ref-jenis-peruntukan-PagedResultDtoOfRefJenisPeruntukanForViewDto",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfRefJenisPeruntukanForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/refJenisPeruntukan/getRefJenisPeruntukanForEdit",
 *     tags={"RefJenisPeruntukan"},
 *     summary="Get RefJenisPeruntukan by id",
 *     operationId="ref-jenis-peruntukan-GetRefJenisPeruntukanForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="RefJenisPeruntukan Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetRefJenisPeruntukanForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/refJenisPeruntukan/getRefJenisPeruntukanForDropdown",
 *     tags={"RefJenisPeruntukan"},
 *     summary="Get all RefJenisPeruntukan in dropdown list",
 *     operationId="ref-jenis-peruntukan-getRefJenisPeruntukanForDropdown",
 *     @OA\Parameter(
 *     name="filter",
 *     description="Filter records with a string",
 *     in="query",
 *     @OA\Schema(
 *         type="string"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetRefJenisPeruntukanForListDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/refJenisPeruntukan/createOrEdit",
 *     tags={"RefJenisPeruntukan"},
 *     summary="Create or edit RefJenisPeruntukan",
 *     operationId="ref-jenis-peruntukan-CreateOrEditRefJenisPeruntukanDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditRefJenisPeruntukanDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditRefJenisPeruntukanDto")
 *     )
 * )
 */
