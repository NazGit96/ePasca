<?php

namespace app\Http\OpenApi;

/**
 * @OA\Get(
 *     path="/api/refJenisBencana/getAll",
 *     tags={"RefJenisBencana"},
 *     summary="Get all RefJenisBencana",
 *     operationId="ref-jenis-bencana-PagedResultDtoOfRefJenisBencanaForViewDto",
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
 *         @OA\JsonContent(ref="#/components/schemas/PagedResultDtoOfRefJenisBencanaForViewDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/refJenisBencana/getRefJenisBencanaForEdit",
 *     tags={"RefJenisBencana"},
 *     summary="Get RefJenisBencana by id",
 *     operationId="ref-jenis-bencana-GetRefJenisBencanaForEditDto",
 *     @OA\Parameter(
 *     name="id",
 *     description="RefJenisBencana Id",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="integer"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/GetRefJenisBencanaForEditDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Get(
 *     path="/api/refJenisBencana/getRefJenisBencanaForDropdown",
 *     tags={"RefJenisBencana"},
 *     summary="Get all RefJenisBencana in dropdown list",
 *     operationId="ref-jenis-bencana-getRefJenisBencanaForDropdown",
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
 *         @OA\JsonContent(ref="#/components/schemas/GetRefJenisBencanaForListDto")
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

/**
 * @OA\Post(
 *     path="/api/refJenisBencana/createOrEdit",
 *     tags={"RefJenisBencana"},
 *     summary="Create or edit RefJenisBencana",
 *     operationId="ref-jenis-bencana-CreateOrEditRefJenisBencanaDto",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputCreateJenisBencanaDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/CreateOrEditRefJenisBencanaDto")
 *     )
 * )
 */
