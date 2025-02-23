<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function accountMaintenance(Request $request)
    {
        $user = Auth::user();

        $users = User::all();

        if ($user->role === 'admin') {
            return view('account-maintenance', [
                'users' => $users,
            ]);
        }

        return abort(403, 'Unauthorized action.');
    }

    public function profile()
    {
        $user = Auth::user();
        // $user = User::find(1);

        return view('profile', [
            'user' => $user,
        ]);
    }

    public function editAccount(Request $request)
    {
        $user = User::find($request->users_id);

        return view('edit-user', [
            "user" => $user,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = User::find($request->users_id); // Get logged-in user

        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6|confirmed', // 'confirmed' ensures password_confirmation field matches
        ]);

        // Update user data
        $user->name = $request->name;
        $user->email = $request->email;

        // Check if password is provided
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save(); // Save changes

        return redirect()->intended('/account-maintenance')->with('success', 'Profile updated successfully!');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $remember_me = $request->has('remember_me');

        // Coba login dengan Auth::attempt()
        if (Auth::attempt($credentials, $remember_me)) {
            session()->put('auth_user_id', Auth::id()); // Simpan user ID manual
            session()->save(); // Paksa Laravel menyimpan session
            return redirect()->intended('/');
        }

        // Jika gagal, cek user secara manual dan login
        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user, $remember_me);
            session()->put('auth_user_id', Auth::id());
            session()->save();
            return redirect()->intended('/');
        }

        return back()->with('loginError', 'Email atau Password salah!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->intended('/signin'); // Redirect to login after logout
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
