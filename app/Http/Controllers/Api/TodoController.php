<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



     /**
     * @OA\Get(
     *     path="/api/todo/getall",
     *     tags={"Todo List"},
     *     operationId="index",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function index()
    {
        $user = auth()->user();
        $data = array_merge($user->toArray(),
        [
            'todos' => Todo::orderBy('id','DESC')
            ->where('author',Auth::user()->id)
            ->get()
        ]);
        return response()->json($data, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *     path="/api/todo/store",
     *     tags={"Todo List"},
     *     operationId="store",
     *     @OA\Parameter(
     *          name="title",
     *          description="title",
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
     *          name="description",
     *          description="description",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string"
     *          )
     *     ),
     *     @OA\Parameter(
     *          name="author",
     *          description="author",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            "title"     => "required|string|max:40",
            "description"     => "required|string|max:500",
            "author"      => "required",
        ]);

        if ($validation->fails()) :
            return ResponseHelper::responseValidation($validation->errors());
        endif;

        try{
            $todo               = new Todo();
            $todo->title        = $request->title;
            $todo->slug         = Str::slug($request->title);
            $todo->description  = $request->description;
            $todo->author       = Auth::user()->id;
            $todo->save();

            return ResponseHelper::responseCreated('Todo List has been added successfully!', $todo);
        }catch(Exception $e){
            return ResponseHelper::responseError($e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/todo/show/{id}",
     *     tags={"Todo List"},
     *     operationId="show",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function show($id)
    {
        $user = auth()->user();
        $data = array_merge($user->toArray(),
        [
            'todos' => Todo::where('id',$id)
            ->first()
        ]);
        return response()->json($data, 200);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/todo/edit/{id}",
     *     tags={"Todo List"},
     *     operationId="edit",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function edit($id)
    {
        $todo = Todo::where('id',$id)->first();
        return response()->json($todo, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /**
     * @OA\Put(
     *     path="/api/todo/update/{id}",
     *     tags={"Todo List"},
     *     operationId="update",
     *     @OA\Parameter(
     *          name="title",
     *          description="title",
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
     *          name="description",
     *          description="description",
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
     *     @OA\Parameter(
     *          name="author",
     *          description="author",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *     ),
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $validation = Validator::make($request->all(), [
            "title"     => "required|string|max:40",
            "description"  => "required|string|max:500",
            "author"      => "required",
        ]);

        if ($validation->fails()) :
            return ResponseHelper::responseValidation($validation->errors());
        endif;


        try{
            $title = $request->input('title');
            $slug = Str::slug($request->get('title'));
            $description = $request->input('description');
            $author = $request->input('author');

            $todo = Todo::find($id);
            $todo->title = $title;
            $todo->slug  = $slug;
            $todo->author= $author;
            $todo->description= $description;
            $todo->save();
            return ResponseHelper::responseCreated('Todo list has been updated successfully!', $todo);
        }catch(Exception $e){
            return ResponseHelper::responseError($e->getMessage(), 400);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Delete(
     *     path="/api/todo/delete/{id}",
     *     tags={"Todo List"},
     *     operationId="delete",
     *     @OA\Response(
     *         response="default",
     *         description="successful operation"
     *     )
     * )
     */
    public function destroy($id)
    {
        $todo = Todo::find($id);
        $todo->delete();
        return ResponseHelper::responseSuccess('Todo list has been removed successfully!');
    }
}
