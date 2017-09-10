<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Log;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth");
    }

    public function index()
    {
        return view('users', ['users' => User::all()]);
    }

    public function getUser($id)
    {
        return view('users-addedit', ['user' => User::find($id)]);
    }

    public function getCreateUser()
    {
        return view('users-addedit', ['user' => new User()]);
    }

    public function postCreateUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role'  => 'required',
            'password'  => 'required|confirmed'
        ]);

        User::create($request->only(['name', 'email', 'role', 'password', 'phone_number', 'address']));

        return redirect('/users')->with('message', 'Uspešno dodat novi korisnik!');
    }

    public function postUpdateUser($id, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'role'  => 'required',
            'password'  => 'confirmed'
        ]);

        $data = $request->only(['name', 'email', 'role', 'password', 'phone_number', 'address']);

        if (array_key_exists('password', $data) && ($data['password'] == "" || $data['password'] == null)) {
            unset($data['password']);
            unset($data['password_confirmed']);
        }

        User::where('id', $id)->update($data);

        return redirect('/users')->with('message', "Korisnik ".$request->input('name')." uspešno ažuriran!");
    }

}
