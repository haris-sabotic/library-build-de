<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        
        /*
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'userType_id' => 2,
            'username' => $request->name,
            'jmbg' => '1234567891234'
        ]);


        $user->userType_id = 2;
        $librarian->username = $request->name;
        $librarian->jmbg = 1234567891234;

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
        */


        $librarian = new User();

        $librarian->userType_id = 1;

        $librarian->name              = 'admin';
        $librarian->jmbg              = '1234567890123';
        $librarian->email_verified_at = now();
        $librarian->email             = 'admin@gmail.com';
        $librarian->username          = 'admin';
        $librarian->remember_token    = 'jlskasjjks';

        $password = 'password';
        $passwordRepeat = 'password';

        $librarian->password=Hash::make($password);

        $librarian->save();
    }
}
