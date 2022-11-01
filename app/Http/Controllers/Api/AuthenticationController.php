<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Helpers\ResponseHelper;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationController extends Controller
{

    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Authentication"},
     *     operationId="register",
     *     @OA\Parameter(
     *          name="name",
     *          description="name",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="slug",
     *          description="slug",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="email",
     *          description="Email",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="password",
     *          description="Password",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="password_confirmation",
     *          description="password_confirmation",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */

    public function register(Request $request)
    {

        $validation = Validator::make($request->only('name','slug','email','password','password_confirmation'), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
       ]);

       if($validation->fails()) :
            return response()->json([
                'status' => false,
                'message' => $validation->errors(),
            ],404);
        endif;

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->slug = Str::slug($request->get('name'));
        $user->save();
        $user->roles()->attach(1);

        return response()->json(
            [
            'status' => true,
            'message' => 'Registration Successful!'
            ], 201);
    }


    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Authentication"},
     *     operationId="login",
     *     @OA\Parameter(
     *          name="email",
     *          description="Email",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="password",
     *          description="Password",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $status = 200;
            $user = Auth::user();
            $response = [
                    'message' => 'You have successfully logged in!',
                    'user' => array_merge($user->toArray(),
                    ['roles' => $user->roles()->get()->toArray()]),
                    'token' => JWTAuth::fromUser($user),

        ];
        }  else {
            $status = 422;
            $response = ['error' => 'The email or password is incorrect.'];
        }

        return response()->json($response, $status);
    }


    /**
     * @OA\Get(
     *     path="/api/user",
     *     tags={"Authentication"},
     *     operationId="User",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function getUser()
    {
        $user = auth()->user();
        $data = array_merge($user->toArray(),
        [
            'roles' => $user->roles()->get()->toArray(),
        ]);
        return response()->json($data, 200);
    }


    /**
     * @OA\Get(
     *     path="/api/logout",
     *     tags={"Authentication"},
     *     operationId="logout",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function logout(Request $request)
    {
        // Auth::logout();
        // return ResponseHelper::responseSuccess('Log out successfully!');

        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);
        if ($validator->fails()) {
            return ResponseHelper::responseValidation($validator->errors());
        }

        try {
            JWTAuth::invalidate($request->token);
            return ResponseHelper::responseSuccess('Logout Successful!');
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to log out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
