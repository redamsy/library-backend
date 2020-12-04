<?php

namespace App\Http\Controllers;

use App\Admin;
use App\User;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //make a  non client user an admin
        if( $admin = Admin::where('id', Auth::guard('api')->user()->id )->exists()){
            $user = User::where('email', $request->input('email') )->first();
            if($user){
                if(!(Admin::where('id', $user->id )->exists())) {
                    $adminCreate = Admin::create([
                        "id" => $user->id,
                        "user_id" => $user->id,
                    ]);
                    if($user) {
                        return new UserResource($user);
                    }
                }
                return response()->json(["message" => "Resource already exist"], 409);
            }
            return response()->json(["message" => "User is not registered"], 409);
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
    }
}
