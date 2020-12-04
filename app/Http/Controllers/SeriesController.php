<?php

namespace App\Http\Controllers;

use App\Serie;
use App\Admin;
use App\Http\Resources\SerieResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $series = Serie::all();
        return SerieResource::collection($series);
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
            if(!(Serie::where('name', $request->input('name') )->exists())){
                $serieCreate = Serie::create([
                    "name" => $request->name,
                ]);
                if($serieCreate) {
                    return new SerieResource($serieCreate);
                }
            }
            return response()->json(["message" => "Resource already exist"], 409);
        }
        return response()->json(["message" => "You are not an admin"], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Serie  $serie
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $serie = Serie::findOrFail($id);
        return new SerieResource($serie);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Serie  $serie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if( $admin = Admin::where('id', Auth::guard('api')->user()->id )->exists()){
            $exists = Serie::where('name', $request->input('name') )
            ->where('id','<>', $id )
            ->count();
            if($exists < 1){
                $serie = Serie::findOrFail($id);
                $serieUpdate = Serie::where('id', $serie->id)
                    ->update([
                            'name'=> $request->name,
                    ]);
            
                if($serieUpdate){
                    return new SerieResource(Serie::findOrFail($id));
                }
            }
            return response()->json(["message" => "Resource already exist"], 409);
        }
        return response()->json(["message" => "You are not an admin"], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Serie  $serie
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if( $admin = Admin::where('id', Auth::guard('api')->user()->id )->exists()){
            $serie = Serie::findOrFail($id);
            
            if($serie->delete()){
                return response()->json(["message" => "serie deleted"], 201);
            }
        }
        return response()->json(["message" => "You are not an admin"], 401);
    }
}
