<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\UserResource;
use App\Http\Controllers\Controller;

/**
 * The User controller.
 *
 * @author  Gleb Karpushkin  <rugleb@gmail.com>
 *
 * @package App\Http\Controllers\API
 */
class UserController extends Controller
{
    /**
     * The User controller constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display the specified resource.
     *
     * @param  Request  $request
     * @return UserResource
     */
    public function show(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @return UserResource
     */
    public function update(Request $request)
    {
        /**
         * @var  \App\User  $user
         */
        $user = $request->user();

        $user->update($request->only($user->getFillable()));

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return UserResource
     *
     * @throws \Exception
     */
    public function destroy(Request $request)
    {
        $request->user()->delete();

        return response()->json([], Response::HTTP_OK);
    }
}
