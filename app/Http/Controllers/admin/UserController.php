<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(){
        $users= User::orderBy('created_at','ASC')->paginate(10);
        return view('admin.user.list',['users' => $users]);
    }
    public function edit($id){
        $user=User::findOrFail($id);
        return view('admin.user.edit',[
            'user' => $user
        ]);
    }
    public function update($id, Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email', 
        ]);

        if ($validator->passes()) {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->designation = $request->designation;
            $user->save();

            session()->flash('success', 'User information updated successfully');

            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy(Request $request){
        $id = $request->id;
        
        $user = User::find($id);
        
        if($user == null){
            session()->flash('error', 'User not found');
    
            return response()->json([
                'status' => false,
            ]);
        }
        
        $user->delete();
        session()->flash('success', 'User deleted successfully');
    
        return response()->json([
            'status' => true,
            'errors' => []
        ]);
    }
    
}