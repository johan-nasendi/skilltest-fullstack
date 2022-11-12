<?php

namespace App\Http\Controllers\Api;

use App\ApiCode;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Helpers\ResponseHelper;
use App\Http\Requests\ResetPasswordRequest;
use Symfony\Component\HttpFoundation\Response;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthenticationController extends Controller
{

     /**
     * @OA\Get(
     *     path="/api/user/all",
     *     tags={"Authentication"},
     *     operationId="Userall",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */

    public function index()
    {
        $user = User::with('roles')->orderBy('id', 'desc')->paginate(10);
        return response()->json($user, 200);
    }

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
        $credentials = $request->only('email', 'password');
        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        if ($validator->fails()) {
            return ResponseHelper::responseValidation($validator->errors());
        }

        // Request divalidasi
        // buat token
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json([
                	'status' => false,
                	'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
    	return $credentials;
            return response()->json([
                	'status' => false,
                	'message' => 'Could not create token.',
                ], 500);
        }

 		//Token dibuat, kembali dengan respons sukses dan token jwt
         $user = Auth::user();
        return response()->json([
            'status' => true,
            'message' => 'You have successfully logged in!',
            'token' => $token,
            'user' => array_merge($user->toArray(),
            ['roles' => $user->roles()->get()->toArray()]),

        ]);

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
        return response()->json($data,200);
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


    /**
     * @OA\Post(
     *     path="/api/password/reset",
     *     tags={"ForgotPassowrd"},
     *     operationId="resetPassword",
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
    public function reset(ResetPasswordRequest $request)
    {
        $reset_password_status = Password::reset($request->validated(), function ($user, $password) {
            $user->password =  Hash::make($password);
            $user->save();
        });

        if ($reset_password_status == Password::INVALID_TOKEN) {
            return response()->json(
                [
                "status" => false,
                "message" => "Invalid token provided"
            ], 400);
        }
        return response()->json(
            [
                "status" => true,
                "message" => "Password has been successfully changed"
            ]
        );


    }

    /**
     * @OA\Post(
     *     path="/api/password/email",
     *     tags={"ForgotPassowrd"},
     *     operationId="sendemail",
     *     @OA\Parameter(
     *          name="email",
     *          description="Email",
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
    public function forgot() {
        $credentials = request()->validate(['email' => 'required|email']);

        Password::sendResetLink($credentials);
        return response()->json(
            [
                "status" => true,
                "message" => "Reset password link sent on your email id."
            ]);
    }

}
