<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        return response()->json(Permission::all());
    }

    public function assign(Request $request,User $user){
        $user->permissions()->sync($request->input('ids'));
        return response()->json(['message' => 'assigned ']);
    }
}
