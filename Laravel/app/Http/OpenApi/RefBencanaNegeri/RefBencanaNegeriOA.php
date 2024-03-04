<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/refBencanaNegeri/getAll",
 *     tags={"RefBencanaNegeri"},
 *     summary="Get all RefBencanaNegeri",
 *     operationId="ref-bencana-negeri-PagedResultDtoOfRefBencanaNegeriForViewDto",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfRefBencanaNegeriForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/refBencanaNegeri/getRefBencanaNegeriForEdit",
 *     tags={"RefBencanaNegeri"},
 *     summary="Get RefBencanaNegeri by id",
 *     operationId="ref-bencana-negeri-GetRefBencanaNegeriForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="RefBencanaNegeri Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetRefBencanaNegeriForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/refBencanaNegeri/getRefBencanaNegeriForDropdown",
 *     tags={"RefBencanaNegeri"},
 *     summary="Get all RefBencanaNegeri in dropdown list",
 *     operationId="ref-bencana-negeri-getRefBencanaNegeriForDropdown",
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
 *         @OA\JsonContent(ref="#/components/schemas/GetRefBencanaNegeriForListDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/refBencanaNegeri/getRefBencanaNegeriForDropdownByIdBencana",
 *     tags={"RefBencanaNegeri"},
 *     summary="Get all RefBencanaNegeri in dropdown list by id bencana",
 *     operationId="ref-bencana-negeri-getRefBencanaNegeriForDropdownByIdBencana",
 *     @OA\Parameter(
 *     name="filter",
 *     description="Filter records with a string",
 *     in="query",
 *     @OA\Schema(
 *         type="string"
 *        )
 *     ),
 *     @OA\Parameter(
 *     name="filterIdBencana",
 *     description="Filter records with a integer",
 *     in="query",
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetRefBencanaNegeriForListByBencanaDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/refBencanaNegeri/createOrEdit",
 *     tags={"RefBencanaNegeri"},
 *     summary="Create or edit RefBencanaNegeri",
 *     operationId="ref-bencana-negeri-CreateOrEditRefBencanaNegeriDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditRefBencanaNegeriDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditRefBencanaNegeriDto")
 *     )
 * )
 */
