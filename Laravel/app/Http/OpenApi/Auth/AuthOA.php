<?php

namespace app\Http\OpenApi;

/**
 * @OA\Post(
 *     path="/api/auth/registerUser",
 *     tags={"Authentication"},
 *     summary="Register Pengguna",
 *     operationId="auth-registerPengguna",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputLoginDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/RegisterPenggunaDto")
 *     )
 * )
 */

  /**
 * @OA\Post(
 *     path="/api/auth/login",
 *     tags={"Authentication"},
 *     summary="Log masuk",
 *     operationId="auth-login",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputLoginDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/InputLoginDto")
 *     )
 * )
 */

   /**
 * @OA\Post(
 *     path="/api/auth/forgotPassword",
 *     tags={"Authentication"},
 *     summary="Lupa kata laluan",
 *     operationId="auth-forgotPassword",
 *     @OA\Response(
 *         response="200",
 *         description="Success"
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/InputForgotPasswordDto")
 *     )
 * )
 */

 /**
 * @OA\Get(
 *     path="/api/auth/verifyCode",
 *     tags={"Authentication"},
 *     summary="Semak kod akses reset",
 *     operationId="auth-verifyCode",
 *     @OA\Parameter(
 *     name="emel",
 *     description="user email address",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="string"
 *        )
 *     ),
 *     @OA\Parameter(
 *     name="kod_akses",
 *     description="Kod akses to verify",
 *     in="query",
 *     required=true,
 *     @OA\Schema(
 *         type="string"
 *        )
 *     ),
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *     ),
 *    @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     )
 * )
 */

   /**
 * @OA\Post(
 *     path="/api/auth/resetPassword",
 *     tags={"Authentication"},
 *     summary="Tukar kata laluan",
 *     operationId="auth-resetPassword",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *         @OA\JsonContent(ref="#/components/schemas/OutputLoginDto")
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Create or edit object",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/InputResetPasswordDto")
 *     )
 * )
 */

  /**
 * @OA\Post(
 *     path="/api/auth/changePassword",
 *     tags={"Authentication"},
 *     summary="Update kata laluan pengguna",
 *     operationId="auth-changePassword",
 *     @OA\Response(
 *         response="200",
 *         description="Success",
 *     ),
 *     @OA\Response(
 *         response="500",
 *         description="Internal error has occured"
 *     ),
 *     @OA\RequestBody(
 *         description="Change Password Input",
 *         required=true,
 *         @OA\JsonContent(ref="#/components/schemas/AuthChangePasswordDto")
 *     )
 * )
 */
