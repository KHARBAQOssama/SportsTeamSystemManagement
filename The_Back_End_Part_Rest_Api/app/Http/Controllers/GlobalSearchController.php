<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\User;
use App\Models\Branch;
use App\Models\Tournament;
use Illuminate\Http\Request;

class GlobalSearchController extends Controller
{
    public function index(Request $request){
        $search  = $request->input('search');
        $data = [
            'users' => User::where('first_name','like','%'.$search.'%')
                            ->orWhere('last_name','like','%'.$search.'%')
                            ->orWhere('email','like','%'.$search.'%')->get(),
            'branch' => Branch::where('name','like','%'.$search.'%')->get(),
            'tournaments' => Tournament::where('name','like','%'.$search.'%')->get(),
            'blogs' => Blog::where('title','like','%'.$search.'%')->get(),
        ];

        return response()->json($data);
    }
}
