<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'jmbg' => 'digits:13|unique:users,jmbg',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
            'password_confirmation' => 'same:password'
        ]);


        $student = new User();

        $student->userType_id = 3;

        $student->name              = $request->name;
        $student->jmbg              = $request->jmbg;
        $student->email_verified_at = now();
        $student->email             = $request->email;
        $student->username          = str_replace(' ', '', strtolower($request->name));
        $student->remember_token    = Str::random(10);
        $student->photo    = 'default.jpg';

        $student->password=Hash::make($request->password);

        $student->save();
    }
}
