<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/refSumberPeruntukan/getAll",
 *     tags={"RefSumberPeruntukan"},
 *     summary="Get all RefSumberPeruntukan",
 *     operationId="ref-sumber-peruntukan-PagedResultDtoOfRefSumberPeruntukanForViewDto",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfRefSumberPeruntukanForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/refSumberPeruntukan/getRefSumberPeruntukanForEdit",
 *     tags={"RefSumberPeruntukan"},
 *     summary="Get RefSumberPeruntukan by id",
 *     operationId="ref-sumber-peruntukan-GetRefSumberPeruntukanForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="RefSumberPeruntukan Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetRefSumberPeruntukanForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/refSumberPeruntukan/getRefSumberPeruntukanForDropdown",
 *     tags={"RefSumberPeruntukan"},
 *     summary="Get all RefSumberPeruntukan in dropdown list",
 *     operationId="ref-sumber-peruntukan-getRefSumberPeruntukanForDropdown",
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
 *         @OA\JsonContent(ref="#/components/schemas/GetRefSumberPeruntukanForListDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/refSumberPeruntukan/createOrEdit",
 *     tags={"RefSumberPeruntukan"},
 *     summary="Create or edit RefSumberPeruntukan",
 *     operationId="ref-sumber-peruntukan-CreateOrEditRefSumberPeruntukanDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditRefSumberPeruntukanDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditRefSumberPeruntukanDto")
 *     )
 * )
 */
