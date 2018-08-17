<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * The API logout controller.
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com>
 *
 * @package App\Http\Controllers\API\Auth
 */
class LogoutController extends Controller
{
    /**
     * The Logout controller constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Revoke user's access token.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function logout(Request $request)
    {
        return response()->json([
            'status' => (bool) $request->user()->token()->delete()
        ]);
    }
}
