<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Employee;
use App\Notifications\SignupActivate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] username
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed'
        ]);
        $user = new Employee([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            // 'activation_token' => str_random(60)
        ]);
        $user->save();  
        // $user->notify(new SignupActivate($user));
        return response()->json([
            'message' => 'Successfully created user!'
        ], 201);
    }
  
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        $request->request->add(['username' => $request->email]); //add request
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $ACCOUNT = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $credentials = request([$ACCOUNT, 'password']);
        $credentials['deleted_at'] = null;
        
        $tokenRequest = $request->create('/oauth/token', 'POST', $request->all());
        $request->request->add([
            "client_id"     => env('CLIENT_ID'),
            "client_secret" => env('CLIENT_SECRET'),
            "grant_type"    => 'password',
            "code"          => '*',
        ]);
        
        $response = Route::dispatch($tokenRequest);
        $json = (array) json_decode($response->getContent());

        if(isset($json['error']) && $json['error']=='invalid_grant'){
            return response()->json([
                'status' => false,
                'messages' => [
                    'failed' => 'Sorry there is no data match'
                ]
            ], 401);
        }

        $json['status'] = true;
        $json['messages'] = [
            'success' => "Successfully login"
        ];
        $json['data'] = $this->retrieveByCredentials($credentials);
        $response->setContent(json_encode($json));
        return $response;
    }
  
    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
  
    /**
     * Get the authenticated Employee
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function signupActivate($token)
    {
        $user = Employee::where('activation_token', $token)->first();
        if (!$user) {
            return response()->json([
                'message' => 'This activation token is invalid.'
            ], 404);
        }
        $user->active = true;
        $user->activation_token = '';
        $user->save();
        return $user;
    }

	public function retrieveByCredentials (array $credentials) {
		$user = new Employee;
		foreach ($credentials as $credentialKey => $credentialValue) {
			if (!Str::contains($credentialKey, 'password')) {
				$user = $user->where($credentialKey, $credentialValue);
			}
        }
        $user->select(
            'employees.id',
            'employees.name',
            'employees.username',
            'employees.email',
            'employees.birth_date',
            'employees.sex',
            'employees.entry_date',
            'employees.avatar',
            'employees.nip',
            'cities.name as city',
            'branches.name as branch',
            'divisions.name as division',
            'positions.name as position',
            'pillars.name as pillar',
            'cities.id as citiesid',
            'branches.id as branchesid',
            'divisions.id as divisionsid',
            'positions.id as positionsid',
            'pillars.id as pillarsid'
        )
        ->leftjoin('cities','cities.id','employees.city')
        ->leftjoin('branches','branches.id','employees.branch')
        ->leftjoin('divisions','divisions.id','employees.division')
        ->leftjoin('positions','positions.id','employees.position')
        ->leftjoin('pillars','pillars.id','employees.pillar')
        ;
        $employee = $user->first();
        // dd(getSql($user));
        $employee->avatar = url('public/' . $employee->avatar);
		return $employee;
	}
}
