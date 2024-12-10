<?php

namespace App\Http\Controllers\Taufik;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;

use App\Http\Requests\Taufik\UserRequest;
use Illuminate\Support\Facades\Hash;

class TaufikController extends Controller
{
    public function index(){
        $users = UserResource::collection(User::all());
        // $userAll = User::all();
        // return $users;
        // return $userAll;
        return view('taufik', [
            'users' => $users
        ]);
    }

    public function createUser(UserRequest $request){
        $request->validated();
        try{
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            \Log::error($user);
        }catch(Exception){
            \Log::error($e);
        }

        return redirect()->route('taufik.index');
    }
}
