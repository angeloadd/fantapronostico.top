<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\Ranking\RankingCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

final class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // classifica completa
    public function officialStanding()
    {
        $standing = (new RankingCalculator())->get();

        return view('bet.standing', compact('standing'));
    }

    public function resetPassword()
    {
        return view('password.reset');
    }

    public function storePassword(Request $request)
    {
        $user = Auth::user();

        $hashedPassword = $user->password;
        if (Hash::check($request->old_password, $hashedPassword)) {
            $validator = Validator::make(
                $request->all(),
                [
                    'password' => 'required|confirmed|min:4|max:8',
                    'password_confirmation' => 'required|min:4|max:8',
                ],
                [
                    'password.confirmed' => 'Le password non corrispondono',
                    'password.required' => 'Immetti una nuova password',
                    'password_confirmation.required' => 'Reimmetti la password scelta',
                    'password.min' => 'La password deve avere minimo :min caratteri',
                    'password.max' => 'La password deve avere massimo :max caratteri',
                ]
            );
            if ($validator->fails()) {
                return redirect(route('password.firstSet'))
                    ->withErrors($validator)
                    ->withInput();
            }
            $user->password = bcrypt($request['password']);
            $user->first_time_login = false;
            $user->save();

            return redirect(route('/'));
        }

        return back()->with('error_message', 'La vecchia password non corrisponde');
    }
}
