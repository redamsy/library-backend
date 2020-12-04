<?php

namespace App\Http\Controllers;

use App\BookCategory;
use App\Admin;
use App\Http\Resources\BookCategoryResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BookCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bookCategories = BookCategory::all();
        return BookCategoryResource::collection($bookCategories);
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
            if(!(BookCategory::where('book_id', $request->input('book_id') )
                ->where('category_id', $request->input('category_id') )->exists())
            ){

                $bookCategoryCreate = BookCategory::create([
                    "book_id" => $request->book_id,
                    "category_id" => $request->category_id,
                ]);
                if($bookCategoryCreate){
                    return new BookCategoryResource($bookCategoryCreate);
                }
            }
            return response()->json(["message" => "Resource already exist"], 409);
        }
        return response()->json(["message" => "You are not an admin"], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if( $admin = Admin::where('id', Auth::guard('api')->user()->id )->exists()){
            $exists = BookCategory::where('book_id', $request->input('book_id') )
                ->where('category_id', $request->input('category_id') )
                ->where('id','<>', $id )
                ->count();
            if($exists < 1){
                $bookCategory = BookCategory::findOrFail($id);
                $bookCategoryUpdate = BookCategory::where('id', $bookCategory->id)
                    ->update([
                        "book_id" => $request->book_id,
                        "category_id" => $request->category_id,
                    ]);
            
                if($bookCategoryUpdate){
                    return new BookCategoryResource(BookCategory::findOrFail($id));
                }
            }
            return response()->json(["message" => "Resource already exist"], 409);
        }
        return response()->json(["message" => "You are not an admin"], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if( $admin = Admin::where('id', Auth::guard('api')->user()->id )->exists()){
            $bookCategory = BookCategory::findOrFail($id);
            
            if($bookCategory->delete()){
                return response()->json(["message" => "bookCategory deleted"], 201);
            }
        }
        return response()->json(["message" => "You are not an admin"], 401);
    }
}
