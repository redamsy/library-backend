<?php

namespace App\Http\Controllers;

use App\Client;
use App\Admin;
use App\User;
use App\Http\Resources\ClientResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if( $admin = Admin::where('id', Auth::guard('api')->user()->id )->exists()){
            $clients = Client::all();
            return ClientResource::collection($clients);
        }
        return response()->json(["message" => "You are not an admin"], 401);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $client = Client::findOrFail($id);
        return new ClientResource($client);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        if( $admin = Admin::where('id', Auth::guard('api')->user()->id )->exists()){
            $exists = Client::where('phoneNumber', $request->input('phoneNumber') )
            ->where('id','<>', $id )
            ->count();
            if($exists < 1){
                $client = Client::findOrFail($id);
                $clientUpdate = Client::where('id', $client->id)
                    ->update([
                        'phoneNumber'=> $request->phoneNumber,
                    ]);
                $userUpdate = User::where('id', $client->id)
                    ->update([
                        'name'=> $request->name,
                    ]);
            
                if($clientUpdate && $userUpdate){
                    return new ClientResource(Client::findOrFail($id));
                }
            }
            return response()->json(["message" => "Resource already exist"], 409);
        }
        return response()->json(["message" => "You are not an admin"], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if( $admin = Admin::where('id', Auth::guard('api')->user()->id )->exists()){
            $client = Client::findOrFail($id);
            $user = $client->user;
            if($user->delete()){
                if($client->delete()){
                    return response()->json(["message" => "client deleted"], 201);
                }
            }
        }
        return response()->json(["message" => "You are not an admin"], 401);
    }
}
