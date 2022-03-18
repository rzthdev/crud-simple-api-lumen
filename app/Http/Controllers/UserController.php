<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $user = User::all();
        return response()->json($user);

        if (!$user) {
            return response()->json(['message' => 'Data not found'], 404);
        }
    }

    public function show($id){
        $user = User::find($id);
        return response()->json($user);

        if (!$user) {
            return response()->json(['message' => 'Data not found'], 404);
        }
    }

    public function create(Request $request){
        $this->validate($request, [
            "name" => "required",
            "email" => "required|email|unique:users",
            "phone" => "required|numeric|min:9",
            "hobby" => "required"
        ]);

        $data = $request->all();
        $user = User::create($data);

        return response()->json(['message' => 'User successfully created!']);

    }


    public function update(Request $request, $id){
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $this->validate($request, [
            "email" => "email|unique:users",
            "phone" => "numeric|min:9"
        ]);

        $data = $request->all();
        $user->fill($data);
        $user->save();

        return response()->json($user);
    }

    public function delete($id){
        $user = User::find($id);

        if (!$user) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $user->delete();
        return response()->json(['message' => 'User sucessfully deleted!']);
    }
    
}
