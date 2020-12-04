<?php

namespace App\Http\Controllers;

use App\Language;
use App\Admin;
use App\Http\Resources\LanguageResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LanguagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $languages = Language::all();
        return LanguageResource::collection($languages);
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
            if(!(
                Language::where('name', $request->input('name') )
                    ->where('code', $request->input('code'))
                    ->exists()
            )){
                $languageCreate = Language::create([
                    'code'=> $request->code,
                    'name'=> $request->name,
                ]);
                if($languageCreate){
                    return new LanguageResource($languageCreate);
                }
            }
            return response()->json(["message" => "Resource already exist"], 409);
        }
        return response()->json(["message" => "You are not an admin"], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $language = Language::findOrFail($id);
        return new LanguageResource($language);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if( $admin = Admin::where('id', Auth::guard('api')->user()->id )->exists()){
            $exists = Language::where('name', $request->input('name') )
            ->where('code', $request->input('code'))
            ->where('id','<>', $id )
            ->count();
            if($exists < 1){
                $language = Language::findOrFail($id);
                $languageUpdate = Language::where('id', $language->id)
                    ->update([
                        'code'=> $request->code,
                        'name'=> $request->name,
                    ]);
            
                if($languageUpdate){
                    return new LanguageResource(Language::findOrFail($id));
                }
            }
            return response()->json(["message" => "Resource already exist"], 409);
        }
        return response()->json(["message" => "You are not an admin"], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Language  $language
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if( $admin = Admin::where('id', Auth::guard('api')->user()->id )->exists()){
            $language = Language::findOrFail($id);
            
            if($language->delete()){
                return response()->json(["message" => "language deleted"], 201);
            }
        }
        return response()->json(["message" => "You are not an admin"], 401);
    }
}
