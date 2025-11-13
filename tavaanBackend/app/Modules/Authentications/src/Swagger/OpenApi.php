<?php

namespace holoo\modules\Authentications\Swagger;

use OpenApi\Annotations as OA;

/**
 * @OA\Tag(
 *   name="Auth (OTP)",
 *   description="OTP login endpoints (index=GET, store=POST)"
 * )
 */

/**
 * @OA\PathItem(
 *   path="/api/v1/authentications",
 *
 *   @OA\Get(
 *     tags={"Auth (OTP)"},
 *     summary="index: Request OTP (GET)",
 *     description="ارسال کد تایید از طریق GET (برای API resource).",
 *     operationId="authenticationsIndex",
 *
 *     @OA\Parameter(
 *       name="mobile",
 *       in="query",
 *       required=true,
 *       description="شماره موبایل کاربر",
 *       @OA\Schema(type="string", )
 *     ),
 *     @OA\Response(
 *       response=200,
 *       description="OTP sent",
 *       @OA\JsonContent(
 *         @OA\Property(property="success", type="boolean", example=true),
 *         @OA\Property(property="message", type="string", example="OTP sent")
 *       )
 *     ),
 *     @OA\Response(response=404, description="User not found")
 *   ),
 *
 *   @OA\Post(
 *     tags={"Auth (OTP)"},
 *     summary="store: Verify OTP and issue token (POST)",
 *     description="تأیید کد و صدور توکن پاسپورت (Passport Bearer).",
 *     operationId="authenticationsStore",
 *     @OA\RequestBody(
 *       required=true,
 *       @OA\JsonContent(
 *         required={"mobile","code"},
 *         @OA\Property(property="mobile", type="string", example="+98912xxxxxxx"),
 *         @OA\Property(property="code",   type="string", example="123456")
 *       )
 *     ),
 *     @OA\Response(
 *       response=200,
 *       description="Success (Bearer token)",
 *       @OA\JsonContent(
 *         @OA\Property(property="access_token", type="string", example="eyJhbGciOi..."),
 *         @OA\Property(property="token_type",   type="string", example="Bearer"),
 *         @OA\Property(property="list", type="object",
 *           @OA\Property(property="id", type="integer", example=101),
 *           @OA\Property(property="mobile", type="string", example="+98912xxxxxxx")
 *         )
 *       )
 *     ),
 *     @OA\Response(response=404, description="Invalid code or user not found")
 *   )
 * )
 */
final class OpenApi {}
