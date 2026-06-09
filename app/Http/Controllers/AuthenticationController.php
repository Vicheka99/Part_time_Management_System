<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use App\Models\User;

class AuthenticationController extends Controller
{
    public function loginForm(){
        return view('login');
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'login' => ['required', 'string'],
            'password' => ['required', Password::min(8)],
        ]);

        if($validator->fails()){
            $errors = $validator->messages();
            $messsage = implode(", ", $errors->all());
            return back()->with("Error", $messsage);
        }

        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? User::EMAIL : User::USERNAME;

       if(Auth::attempt([$loginField => $request->login, 'password' => $request->password])){
            $user = Auth::user();

            // Check if user has admin role
            if($user->hasRole('admin')){
                return redirect()->route('home'); // Dashboard for admin
            }
            else{
                return redirect()->route('home'); // Profile/Homepage for regular user
            }
       }
       else{
            return back()->with("Error", "Email or password is invalid");
       }

       return redirect()->route('login');

    }

    public function logout(){

        Auth::logout(); //logout
        return redirect()->route('login');
    }
}
