<?php

namespace App\Http\Controllers;

use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;

class AuthenController extends Controller
{
    public function register(){
        return view('auth.register');
    }
    public function storeRegister(Request $request){
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);
        if($validated){
            User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => bcrypt($validated['password']),
            ]);
            $request->session()->regenerate();
        
        }

        return redirect('login');
        

        
    }

    public function formlog(){
        return view('auth.login');
    }

    public function login(Request $request){
        $validated = $request->validate([
            'email' => 'required|string',
            'password' => 'required|min:6',
        ]);
        if($validated){
            if(Auth::attempt($validated)){
                $request->session()->regenerate();
                return redirect('dashboard');
            }
        }
        return back()->withErrors([
        'email' => 'Invalid credentials'
        ]);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('login'));
    }
    
}
