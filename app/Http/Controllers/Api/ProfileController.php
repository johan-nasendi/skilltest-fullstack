<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Str;
class ProfileController extends Controller
{

     /**
     * @OA\Post(
     *     path="/api/profile/change-password",
     *     tags={"Profile"},
     *     operationId="changepassword",
     *     @OA\Parameter(
     *          name="current_passsowrd",
     *          description="current_passsowrd",
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

    public function changePassword(Request $request)
    {
        $validation = Validator::make($request->only('current_passsowrd','password'), [
            'current_passsowrd' => 'required',
            'password' => 'required|min:8|confirmed|different:current_passsowrd',
       ]);

        if(Hash::check($request->current_passsowrd,Auth::user()->password))
        {
            $user = User::find(Auth::user()->id);
            $user->password = Hash::make($request->password);
            $user->save();
            return ResponseHelper::responseCreated('Password has been changed successfully,Please Logout and test your new password!');
        }
        else {
        return response()->json([
                'status' => false,
                'message' => 'Password does not match!'
        ],400);
        }
    }


     /**
     * @OA\Post(
     *     path="/api/profile/upload-photo/{id}",
     *     tags={"Profile"},
     *     operationId="uploadphoto",
     *     @OA\Parameter(
     *          name="userimage",
     *          description="userimage",
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

    public function uploadPhoto($id,Request $request)
    {
        $validation = Validator::make($request->all(), [
            "userimage"      => "required|max:2048",
        ]);

        if ($validation->fails()) :
            return ResponseHelper::responseValidation($validation->errors());
        endif;


        try {
            $user = User::find($id);
            $imageName = time().'.'.$request->userimage->extension();

            $path = public_path('photos');
            if(!empty($user->userimage) && file_exists($path.'/'.$user->userimage)) :
                unlink($path.'/'.$user->userimage);
            endif;

            $user->userimage = $imageName;

            $user->save();

            $request->userimage->move(public_path('photos'), $imageName);

            return ResponseHelper::responseCreated('Uploaded Successfully!', $user);

        } catch(Exception $e){
            return ResponseHelper::responseError($e->getMessage(), 400);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/profile/edit/{id}",
     *     tags={"Profile"},
     *     operationId="editprofile",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function edit($id)
    {
        $user = User::where('id',$id)->first();
        return response()->json($user);
    }


     /**
     * @OA\Put(
     *     path="/api/profile/update/{id}",
     *     tags={"Profile"},
     *     operationId="updateprofile",
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
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */

    public function update(Request $request,$id)
    {

        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,'.$id,
       ]);

       try {
        $user = User::find($id);
        $user->name = $request->name;
        $user->slug = Str::slug($request->get('name'));
        $user->email  = $request->email;
        $user->update();

        return ResponseHelper::responseCreated('Account has been updated successfully!', $user);

        } catch(Exception $e){
            return ResponseHelper::responseError($e->getMessage(), 400);
        }

    }

}
