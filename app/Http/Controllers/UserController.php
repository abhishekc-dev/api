<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json([
            'message' => count($users) . ' Users Found',
            'data' => $users,
            'status' => true,
        ]);
    }

    public function show(string $id)
    {
        $user = User::find($id);
        if ($user != null) {
            return response()->json([
                'message' => 'User Found with Id : ' . $id,
                'status' => true,
                'data' => $user,
            ], 200);
        } else {
            return response()->json([
                'message' => 'User Not Found with Id : ' . $id,
                'status' => false,
                'data' => [],
            ], 200);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($user) {
            return response()->json([
                'message' => 'Record Inserted Successfully',
                'status' => true,
                'data' => $user,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Record Not Inserted',
                'status' => true,
                'data' => [],
            ], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        if ($user == null) {
            return response()->json([
                'message' => 'Record Not Found',
                'status' => false,
                'data' => [],
            ], 404);
        } else {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
            ]);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();
            return response([
                'message' => 'Updated Successfully',
                'status' => true,
                'data' => $user,
            ], 200);
        }

    }

    public function destroy($id)
    {
        $user = User::find($id);
        if ($user == null) {
            return response([
                'message' => 'Record Not Found ',
                'status' => true,
                'data' => [],
            ]);
        } else {
            $deletedUser = $user->delete();
            return response([
                'message' => 'Record Deleted',
                'status' => false,
                'data' => [],
            ]);
        }
    }
}
