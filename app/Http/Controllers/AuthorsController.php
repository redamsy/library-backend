<?php

namespace App\Http\Controllers;

use App\Author;
use App\Admin;
use App\Http\Resources\AuthorResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $authors = Author::all();
        return AuthorResource::collection($authors);
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
            if(!(Author::where('name', $request->input('name') )->exists())){
                if($request->hasFile('image')) {
                    $request->validate([
                    'image' => 'required',
                    'image.*' => 'image|max:2048|mimes:jpeg,png,jpg'
                    ]);
                    $image = $request->image;
                    $imageName = ''; 
                    if ($image->isValid()) {
                        do{  
                            $extension = $image->getClientOriginalExtension(); // getting image extension
                            $imageName = rand(1,99999999).'.'.$extension; // renaming image//or use time().
                        }while(file_exists("images/" . $imageName));
        
                        $image->move(public_path('images/authors'), $imageName); // uploading image to given path

                        if($imageName) {
                            $authorCreate = Author::create([
                                "name" => $request->name,
                                'imageName' => $imageName,
                            ]);
                            if($authorCreate){
                                return new AuthorResource($authorCreate);
                            }
                        }
                    }
                }
                return response()->json(["message" => "image input required"], 400);
            }
            return response()->json(["message" => "Resource already exist"], 409);
        }
        return response()->json(["message" => "You are not an admin"], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $author = Author::findOrFail($id);
        return new AuthorResource($author);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if( $admin = Admin::where('id', Auth::guard('api')->user()->id )->exists()){
            $exists = Author::where('name', $request->input('name') )
            ->where('id','<>', $id )
            ->count();
            if($exists < 1){
                $author = Author::findOrFail($id);
                if($request->hasFile('image')) {
                    $request->validate([
                    'image' => 'required',
                    'image.*' => 'image|max:2048|mimes:jpeg,png,jpg'
                    ]);
                    $image = $request->image;
                    $imageName = ''; 
                    if ($image->isValid()) {
                        do{  
                            $extension = $image->getClientOriginalExtension(); // getting image extension
                            $imageName = rand(1,99999999).'.'.$extension; // renaming image//or use time().
                        }while(file_exists("images/" . $imageName));
        
                        $image->move(public_path('images/authors'), $imageName); // uploading image to given path

                        if($imageName) {
                            $authorUpdate = Author::where('id', $author->id)
                                ->update([
                                        'name'=> $request->name,
                                        'imageName' => $imageName,
                                ]);
                        
                            if($authorUpdate){
                                return new AuthorResource(Author::findOrFail($id));
                            }
                        }
                    }
                    return response()->json(["message" => "Image is not valid"], 400);
                }
                $authorUpdate = Author::where('id', $author->id)
                    ->update([
                            'name'=> $request->name,
                    ]);
            
                if($authorUpdate){
                    return new AuthorResource(Author::findOrFail($id));
                }
            }
            return response()->json(["message" => "Resource already exist"], 409);
        }
        return response()->json(["message" => "You are not an admin"], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Author  $author
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if( $admin = Admin::where('id', Auth::guard('api')->user()->id )->exists()){
            $author = Author::findOrFail($id);
            
            if($author->delete()){
                return response()->json(["message" => "author deleted"], 201);
            }
        }
        return response()->json(["message" => "You are not an admin"], 401);
    }
}
