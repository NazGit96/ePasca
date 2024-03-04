<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/refSumberDana/getAll",
 *     tags={"RefSumberDana"},
 *     summary="Get all RefSumberDana",
 *     operationId="ref-sumber-dana-PagedResultDtoOfRefSumberDanaForViewDto",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfRefSumberDanaForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/refSumberDana/getRefSumberDanaForEdit",
 *     tags={"RefSumberDana"},
 *     summary="Get RefSumberDana by id",
 *     operationId="ref-sumber-dana-GetRefSumberDanaForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="RefSumberDana Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetRefSumberDanaForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/refSumberDana/getRefSumberDanaForDropdown",
 *     tags={"RefSumberDana"},
 *     summary="Get all RefSumberDana in dropdown list",
 *     operationId="ref-sumber-dana-getRefSumberDanaForDropdown",
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
 *         @OA\JsonContent(ref="#/components/schemas/GetRefSumberDanaForListDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/refSumberDana/createOrEdit",
 *     tags={"RefSumberDana"},
 *     summary="Create or edit RefSumberDana",
 *     operationId="ref-sumber-dana-CreateOrEditRefSumberDanaDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputCreateSumberDanaDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditRefSumberDanaDto")
 *     )
 * )
 */
