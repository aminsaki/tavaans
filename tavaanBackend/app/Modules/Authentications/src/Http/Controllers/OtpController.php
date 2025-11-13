<?php

namespace holoo\modules\Authentications\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Authentications\src\Http\Requests\AuthRequest;
use holoo\modules\Authentications\servers\AuthenticationService;
use holoo\modules\Bases\Helper\Responses;
use Illuminate\Http\Request;


class OtpController extends Controller
{

    public function __construct(public Responses $responses,)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index(AuthRequest $request, AuthenticationService $authService): ?\Illuminate\Http\JsonResponse
    {
        return $authService->requestOtp($request->all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, AuthenticationService $authService): ?\Illuminate\Http\JsonResponse
    {
        return $authService->verifyOtp($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user)
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
