<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Modules\Auth\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

final class UserModController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('mod');
    }

    public function index(): Renderable
    {
        return view('mod.usersIndex', ['users' => User::all()]);
    }

    public function create(): Renderable
    {
        return view('mod.userCreate');
    }

    public function modUserEdit(User $user): Renderable
    {
        return view('mod.userEdit', compact('user'));
    }

    public function modUserUpdate(Request $request, User $user): RedirectResponse
    {
        $user->password = Hash::make(str_replace(' ', '', mb_strtolower($user->full_name)));
        $user->save();

        return redirect(route('mod.userEdit', compact('user')))->with('message', 'Dati modificati con successo');
    }

    public function modUserStore(UserStoreRequest $request): RedirectResponse
    {
        $user = new User();
        $user->name = trim($request->input('name'));
        $user->surname = trim($request->input('surname'));
        $user->password = Hash::make(str_replace(' ', '', mb_strtolower(trim($user->full_name))));
        $user->first_time_login = true;
        $user->save();

        Cache::forget('usersRank');

        return redirect(route('mod.usersIndex'))->with('messaggio', 'Nuovo utente creato');
    }

    public function modUserDelete(Request $request, User $user): RedirectResponse
    {
        $deleteControl = $request->mod;
        if (Auth::user()->full_name === $deleteControl) {
            if ($user->admin) {
                return back()->with('message', 'Non hai i permessi per cancellare questo utente');
            }
            $user->delete();

            return redirect(route('mod.usersIndex'))->with('messagge', 'utente cancellato');
        }

        Cache::forget('usersRank');

        return back()->with('message', 'la cancellazione NON è andata a buon fine');
    }
}
