<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index ()
    {
        $users = User::all();
        return view('users.index', [
            'users' => $users,
        ]);
    }

    public function add ()
    {
        return view('users.add');
    }

    public function store ()
    {

    }

    public function edit ()
    {
        return view('users.edit');
    }

    public function update ()
    {

    }

    public function infoEdit ()
    {
        return view('users.infoedit');
    }

    public function infoUpdate (Request $request)
    {
        $validator = validator($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|same:confirmPassword',
            'confirmPassword' => 'required',
        ]);
        if($validator->fails()){
            return back()->withErrors($validator)->withInput();
        }

        // $hashedValue = User::where('id', $request->id)->select('password')->first();
        $name = $request->name;
        $email = $request->email;
        $password = Hash::make($request->password);

        $user = User::where('id', $request->id)->update([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        return redirect(route('root'))->with('info', 'Successfully Updated User Information!');
    }
}
