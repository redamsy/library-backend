<?php

namespace App\Http\Controllers;

use App\BookAuthor;
use App\Admin;
use App\Http\Resources\BookAuthorResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BookAuthorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $bookAuthors = BookAuthor::all();
        return BookAuthorResource::collection($bookAuthors);
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
            if(!(BookAuthor::where('book_id', $request->input('book_id') )
                ->where('author_id', $request->input('author_id') )->exists())
            ){

                $bookAuthorCreate = BookAuthor::create([
                    "book_id" => $request->book_id,
                    "author_id" => $request->author_id,
                ]);
                if($bookAuthorCreate){
                    return new BookAuthorResource($bookAuthorCreate);
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
            $exists = BookAuthor::where('book_id', $request->input('book_id') )
                ->where('author_id', $request->input('author_id') )
                ->where('id','<>', $id )
                ->count();
            if($exists < 1){
                $bookAuthor = BookAuthor::findOrFail($id);
                $bookAuthorUpdate = BookAuthor::where('id', $bookAuthor->id)
                    ->update([
                        "book_id" => $request->book_id,
                        "author_id" => $request->author_id,
                    ]);
            
                if($bookAuthorUpdate){
                    return new BookAuthorResource(BookAuthor::findOrFail($id));
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
            $bookAuthor = BookAuthor::findOrFail($id);
            
            if($bookAuthor->delete()){
                return response()->json(["message" => "bookAuthor deleted"], 201);
            }
        }
        return response()->json(["message" => "You are not an admin"], 401);
    }
}
