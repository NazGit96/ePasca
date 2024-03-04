<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/refPindah/getAll",
 *     tags={"RefPindah"},
 *     summary="Get all RefPindah",
 *     operationId="ref-pindah-PagedResultDtoOfRefPindahForViewDto",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfRefPindahForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/refPindah/getRefPindahForEdit",
 *     tags={"RefPindah"},
 *     summary="Get RefPindah by id",
 *     operationId="ref-pindah-GetRefPindahForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="RefPindah Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetRefPindahForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/refPindah/getRefPindahForDropdown",
 *     tags={"RefPindah"},
 *     summary="Get all RefPindah in dropdown list",
 *     operationId="ref-pindah-getRefPindahForDropdown",
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
 *         @OA\JsonContent(ref="#/components/schemas/GetRefPindahForListDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/refPindah/createOrEdit",
 *     tags={"RefPindah"},
 *     summary="Create or edit RefPindah",
 *     operationId="ref-pindah-CreateOrEditRefPindahDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputCreatePindahDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditRefPindahDto")
 *     )
 * )
 */
