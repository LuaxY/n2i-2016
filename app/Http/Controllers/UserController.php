<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Auth;
use App\User;

class UserController extends Controller
{
    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {

        var_dump($request);


        $validator = Validator::make($request->all(), [
            'email'    => 'required|email|unique,user',
            'password' => 'required|confirmed',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        var_dump("in");
        dd();

        $salt = str_random(8);

        $user = new User;
        $user->email    = $request->input('email');
        $user->password = hash('sha512', $request->input('password') . $salt);
        $user->salt     = $salt;
        $user->save();

        Auth::login($user, true);

        return redirect()->route('home');
    }

    public function login_form()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails())
        {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::where('email', $request->input('email'))->first();

        if (!$user)
        {
            return redirect()->back()->withErrors(['email' => 'Identifiant ou mot de passe incorrect.'])->withInput();
        }

        if ($user->password == hash('sha512', $request->input('password') . $user->salt))
        {
            Auth::login($user, true);
        }

        return redirect()->route('home');
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
    }
}
