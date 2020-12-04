<?php

namespace App\Http\Controllers;

use App\Publisher;
use App\Admin;
use App\Http\Resources\PublisherResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PublishersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $publishers = Publisher::all();
        return PublisherResource::collection($publishers);
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
            if(!(Publisher::where('name', $request->input('name') )->exists())){
                $publishercreate = Publisher::create([
                    "name" => $request->name,
                ]);
                if($publishercreate){
                    return new PublisherResource($publishercreate);
                }
            }
            return response()->json(["message" => "Resource already exist"], 409);
        }
        return response()->json(["message" => "You are not an admin"], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $publisher = Publisher::findOrFail($id);
        return new PublisherResource($publisher);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if( $admin = Admin::where('id', Auth::guard('api')->user()->id )->exists()){
            $exists = Publisher::where('name', $request->input('name') )
            ->where('id','<>', $id )
            ->count();
            if($exists < 1){
                $publisher = Publisher::findOrFail($id);
                $publisherUpdate = Publisher::where('id', $publisher->id)
                    ->update([
                            'name'=> $request->name,
                    ]);
            
                if($publisherUpdate){
                    return new PublisherResource(Publisher::findOrFail($id));
                }
            }
            return response()->json(["message" => "Resource already exist"], 409);
        }
        return response()->json(["message" => "You are not an admin"], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Publisher  $publisher
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if( $admin = Admin::where('id', Auth::guard('api')->user()->id )->exists()){
            $publisher = Publisher::findOrFail($id);
            
            if($publisher->delete()){
                return response()->json(["message" => "publisher deleted"], 201);
            }
        }
        return response()->json(["message" => "You are not an admin"], 401);
    }
}
