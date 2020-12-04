<?php

namespace App\Http\Controllers;

use App\Category;
use App\Admin;
use App\Http\Resources\CategoryResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $categories = Category::all();
        return CategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if( $admin = Admin::where('id', Auth::guard('api')->user()->id )->exists()){
            if(!(Category::where('name', $request->input('name') )->exists())){
                $categoryCreate = Category::create([
                    "name" => $request->name,
                ]);
                if($categoryCreate){
                    return new categoryResource($categoryCreate);
                }
            }
            return response()->json(["message" => "Resource already exist"], 409);
        }
        return response()->json(["message" => "You are not an admin"], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $category = Category::findOrFail($id);
        return new categoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if( $admin = Admin::where('id', Auth::guard('api')->user()->id )->exists()){
            $exists = Category::where('name', $request->input('name') )
                ->where('id','<>', $id )
                ->count();
            if($exists < 1){
                $category = Category::findOrFail($id);
                $categoryUpdate = Category::where('id', $category->id)
                    ->update([
                            'name'=> $request->name,
                    ]);
            
                if($categoryUpdate){
                    return new categoryResource(Category::findOrFail($id));
                }
            }
            return response()->json(["message" => "Resource already exist"], 409);
        }
        return response()->json(["message" => "You are not an admin"], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if( $admin = Admin::where('id', Auth::guard('api')->user()->id )->exists()){
            $category = Category::findOrFail($id);
            
            if($category->delete()){
                return response()->json(["message" => "category deleted"], 201);
            }
        }
        return response()->json(["message" => "You are not an admin"], 401);
    }
}
