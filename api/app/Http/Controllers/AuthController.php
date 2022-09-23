<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;


class AuthController extends Controller
{
    //

    public function login(Request $request)
    {

        // validate
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // user
        $user = User::where('email', $request->email)->first();



        // attempt login
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Invalid email/password. Try again'
            ]);
        }



        //token
        $token = $user->createToken('myapptoken')->plainTextToken;

        // return
        return response()->json(['user' => $user, 'token' => $token]);
    }

    public function register(Request $request)
    {

        // validate

        $request->validate([
            'name' => 'string|required',
            'email' => 'string|required|unique:users,email',
            'password' => 'string|required|confirmed',
        ]);

        // create

        $request->merge([
            'password' => bcrypt($request->password)
        ]);

        $user = User::create($request->only(['name', 'email', 'password']));

        // get token
        $token = $user->createToken('myapptoken')->plainTextToken;

        // respond

        return response()->json(['user' => $user, 'token' => $token]);
    }

    public function createToken(Request $request)
    {
        $user = User::find(1);
        $token = $user->createToken('myapptoken');

        return response()->json(['token' => $token->plainTextToken]);
    }

    public function OAuthProvider($provider)
    {
        return response()->json(['url' => Socialite::driver($provider)->stateless()->redirect()->getTargetUrl()]);
    }

    public function OAuthProviderCallback($provider, Request $request)
    {

        switch ($provider) {
            case 'github':
                $authUser = Socialite::driver($provider)->with([
                    'code' => $request->code,
                ])->stateless()->user();

                // return response()->json(['user' => $authUser]);

                $user_exists = User::where('email', $authUser->email)->first();
                break;
                
                
                case 'google':
                    $authUser = Socialite::driver($provider)->with([
                        'code' => $request->code,
                    ])->stateless()->user();
    
                    // return response()->json(['user' => $authUser]);
    
                    $user_exists = User::where('email', $authUser->email)->first();
                break;

            case 'facebook':
                # code...
                break;



            default:
                # code...
                break;
        }


        if (!$user_exists) {
            $user = User::create([
                'name' => $authUser->name,
                'email' => $authUser->email,
                'password' => bcrypt(Str::random(10)),
            ]);

            Auth::login($user);
        } else {
            Auth::login($user_exists);
        }


        return response()->json(['success' => true, 'user' => $user_exists]);
    }
}
