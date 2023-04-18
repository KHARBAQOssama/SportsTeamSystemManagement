<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api', ['except' => ['store']]);
        // $this->middleware('permission:add user');
    }

    public function index(Request $request)
    {
        $query = User::query();
    
        if ($request->has('role')) {
            $role = $request->input('role');
            $query->where('role_id', $role);
        }

        if ($request->has('sport')) {
            $sport = $request->input('sport');
            $query->where('sport_id', $sport);
        }

        if ($request->has('by_search')) {
            $search = $request->input('by_search');
            $query->where(function ($query) use ($search) {
                $query->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->with(['role', 'permissions', 'sport'])->get();

        return response()->json($users);
    }

    public function store(StoreUserRequest $request)
    {
        $credentials = [
            'first_name'        => $request->input('first_name'),
            'last_name'         => $request->input('last_name'),
            'email'             => $request->input('email'),
            'password'          => Hash::make($request->input('password')),
            'birth_day'         => $request->input('birth_day'),
        ];


        if ($request->input('image')) {
            $base64_string = $request->input('image');
            $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64_string));
    
            $filename = uniqid() . '.jpg';

            Storage::put('public/images/' . $filename, $image_data);
            $url = asset('storage/images/'.$filename);
            $credentials['image_url'] = $url;
        }

        $user = User::create($credentials);

        if(!$user){
            return response()->json([
                'error'=> 'Something went wrong'
            ]);
        }

        return response()->json([
            'message' => 'Account has been created successfully',
            'user' => $user,
        ],201);
    }

    public function storeByAdmin(StoreUserRequest $request){

        $request->validate([
            'role_id' => 'required',
        ]);

        $credentials = [
            'first_name'        => $request->input('first_name'),
            'last_name'         => $request->input('last_name'),
            'email'             => $request->input('email'),
            'password'          => Hash::make($request->input('password')),
            'birth_day'         => $request->input('birth_day'),
        ];

        if($request->input('role_id') == 1 || $request->input('role_id') == 4){
            $credentials['sport_id']        = null;
            $credentials['role_id']         = $request->input('role_id');
        }else{
            $credentials['sport_id']        = $request->input('sport_id');
            $credentials['role_id']         = $request->input('role_id');
        }

        if ($request->input('image')) {
            $base64_string = $request->input('image');
            $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64_string));
    
            $filename = uniqid() . '.jpg';

            Storage::put('public/images/' . $filename, $image_data);
            $url = asset('storage/images/'.$filename);
            $credentials['image_url'] = $url;
        }

        $user = User::create($credentials);

        if(!$user){
            return response()->json([
                'error'=> 'Something went wrong'
            ]);
        }

        return response()->json([
            'success' => 'Account created successfully',
            $user,
        ],201);
    }

    public function show(User $user)
    {
        $user->role = $user->role;
        $user->sport = $user->sport;
        $user->permissions = $user->permissions;
        return response()->json($user);
    }


    public function update(UpdateUserRequest $request, User $user)
    {
        $credentials = [
            'first_name'        => $request->input('first_name'),
            'last_name'         => $request->input('last_name'),
            'email'             => $request->input('email'),
            'birth_day'         => $request->input('birth_day'),
        ];

        if($request->input('role_id') == 1 || $request->input('role_id') == 4){
            $credentials['sport_id']        = null;
            $credentials['role_id']         = $request->input('role_id');
        }else{
            $credentials['sport_id']        = $request->input('sport_id');
            $credentials['role_id']         = $request->input('role_id');
        }

        if ($request->input('image')) {
            $base64_string = $request->input('image');
            $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64_string));
    
            $filename = uniqid() . '.jpg';

            Storage::put('public/images/' . $filename, $image_data);

            $url = asset('storage/images/'.$filename);
            $credentials['image_url'] = $url;
        }

        $user->update($credentials);

        return response()->json([
            'message' => 'Account updated successfully'
        ]);
    }

    public function updateSelf(UpdateUserRequest $request){
        $credentials = [
            'first_name'        => $request->input('first_name'),
            'last_name'         => $request->input('last_name'),
            'email'             => $request->input('email'),
            'birth_day'         => $request->input('birth_day'),
        ];

        $user = JWTAuth::user();
        $user->update($credentials);

        return response()->json([
            'message' => 'Your account updated successfully',
            'user' => $user,
        ]);
    }

    public function updateSelfImage(Request $request){     
        $request->validate([
            'image' => 'required',
        ]);

        $user = JWTAuth::user();

        $credentials = [];

        if ($request->input('image')) {
            $base64_string = $request->input('image');
            $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64_string));
    
            $filename = uniqid() . '.jpg';

            Storage::put('public/images/' . $filename, $image_data);

            $url = asset('storage/images/'.$filename);
            $credentials['image_url'] = $url;
        }

        $user->update($credentials);

        return response()->json([
            'message' => 'image updated successfully',
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'user deleted successfully',
        ]);
    }
}
