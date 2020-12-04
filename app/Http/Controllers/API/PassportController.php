<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Client;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Validator;
use DB;
class PassportController extends Controller
{
    //
    public function register(Request $request)
    {
        $input = $request->all();
        
        if(strcmp($input['userType'], 'CLIENT') == 0){
            $validator = Validator::make($request->all(), [
                'phoneNumber' => 'required|string|max:255|unique:clients',
            ]);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }
        }
    	$validator = Validator::make($request->all(), [
    		'name' => 'required|string|max:255',
    		'email' => 'required|string|email|max:255|unique:users',
    		'password' => 'required|string|min:6',
            'c_password' => 'required|same:password',
    	]);

    	if ($validator->fails()) {
    		return response()->json(['error' => $validator->errors()], 400);
    	}

    	$input['password'] = bcrypt($input['password']);

        $user = User::create($input);
        if(strcmp($input['userType'], 'CLIENT') == 0){
            if ($request->has('phoneNumber')) {
                $client = Client::create([
                    'id' => $user->id,
                    'user_id' => $user->id,
                    'phoneNumber' => $input['phoneNumber']
                ]);
                $success['userType'] = 'CLIENT';
            }
        }
        if(strcmp($input['userType'], 'CLIENT') != 0){
            $success['userType'] = 'ADMIN';
        }
    	$success['token'] = $user->createToken('library')->accessToken;
    	$success['name'] = $user->name;
        $success['email'] = $user->email;

    	return response()->json(['success' => $success], 200);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] = $user->createToken('library')->accessToken;
            $success['name'] = $user->name;
            $success['email'] = $user->email;
            if($user->admin) {
                $success['userType'] = 'ADMIN';
            }
            if($user->client) {
                $success['userType'] = 'CLIENT';
            }
            return response()->json(['success' => $success], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function logout(Request $request)
    {
        if (Auth::guard('api')->check()) {
            DB::table('oauth_access_tokens')
                ->where('user_id', Auth::guard('api')->user()->id)
                ->update([
                    'revoked' => true
                ]);
            return response()->json(['message' => 'success'], 200); 
         }
    }

    public function getAuthenticatedUser()
    {
        $user = Auth::guard('api')->user();
        return new UserResource($user);
    }
}
