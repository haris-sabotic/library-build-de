<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;
use Laravel\Sanctum\HasApiTokens;

class ResetPasswordController extends Controller
{
    use HasApiTokens;

    private $viewFolder = 'pages';

    public function show(string $tokenStr) {
        $token = PersonalAccessToken::where('token', $tokenStr);
        //return User::find($token->get('tokenable_id'));

        $viewName = $this->viewFolder . '.resetPassword';
        return view($viewName, ["token" => $tokenStr]);
    }

    public function sendResetPasswordMail(Request $request)
    {
        $user = User::query()->where('username', $request['username'])->first();
        $token = $user->createToken('authToken');
        $link = $request->root() . "/resetPassword/" . $token->accessToken->token;
        Mail::to($user->email)->send(new ResetPasswordMail($link));
    }

    public function setNewPassword(Request $request)
    {
        $request->validate([
            'password'   => 'required|max:256|min:8|same:passwordConfirm',
            'passwordConfirm'  => 'required|max:256|min:8|same:password',
        ]);


        if (!$request->has('token'))
            return ['msg' => 'missing token'];

        $token = $request['token'];
        $database_token = PersonalAccessToken::where('token', $token)->first();

        if ($database_token) {
            $user = User::query()->find($database_token->tokenable_id);
            $user->update(['password' => Hash::make($request['password'])]);
            $database_token->delete();
            return ['msg' => 'success'];
        } else
            return ['msg' => 'invalid token'];
    }
}
