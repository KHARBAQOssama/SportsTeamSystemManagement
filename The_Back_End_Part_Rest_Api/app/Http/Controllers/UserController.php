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
        $users = User::with('role', 'permissions', 'sport');

        if ($request->has('role')) {
            $role = $request->input('role');
            $usersRole = User::where('role_id', $role);
            $users->mergeConstraintsFrom($usersRole);
        }

        if ($request->has('sport')) {
            $sport = $request->input('sport');
            $usersSport = User::where('sport_id', $sport);
            $users->mergeConstraintsFrom($usersSport);
        }

        if ($request->has('by_search')) {
            $search = $request->input('by_search');
            $usersSearch = User::where('first_name', 'like', "%$search%");
            $users->mergeConstraintsFrom($usersSearch);
        }

        $users = $users->get();

        return response()->json($users);
        // $users = User::with('role','permissions','sport')->query();
        
        // if ($request->has('role')) {
        //     $role = $request->input('role');
        //     $users->where('role_id', $role);
        // }

        // if ($request->has('sport')) {
        //     $role = $request->input('sport');
        //     $users->where('sport_id', $role);
        // }
        
        // if ($request->has('by_search')) {
        //     $search = $request->input('by_search');
        //     $users->where('name', 'like', "%$search%");
        // }
        
        // $users = $users->get();

        // return response()->json($users);
    }

    public function getBySearch(Request $request){
        $searchInput = $request->input('search');
        $sportFilter = $request->input('sport_filter');
        $roleFilter = $request->input('role_filter');
        
        $users = User::query()
            ->when($searchInput, function ($query, $searchInput) {
                return $query->where('first_name', 'like', $searchInput.'%')
                             ->orWhere('last_name', 'like', $searchInput.'%')
                             ->orWhere('email', 'like', $searchInput.'%');
            })
            ->when($sportFilter, function ($query, $sportFilter) {
                return $query->where('sport_id', '=', $sportFilter);
            })
            ->when($roleFilter, function ($query, $roleFilter) {
                return $query->where('role_id', '=', $roleFilter);
            })
            ->get();
    
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

        if($request->input('sport_id')){
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
            'success' => 'Account has been created successfully',
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

        $user->update($credentials);

        return response()->json([
            'success' => 'the user profile has been updated successfully'
        ]);
    }

    public function updateSelf(UpdateUserRequest $request){
        $credentials = [
            'first_name'        => $request->input('first_name'),
            'last_name'         => $request->input('last_name'),
            'email'             => $request->input('email'),
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

        $user = JWTAuth::user();
        $user->update($credentials);

        return response()->json([
            'message' => 'Your account has been updated successfully',
            $user,
        ]);
    }

    public function updateUserImage(Request $request,User $user){
        $request->validate([
            'image' => 'required',
        ]);

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

    public function deleteUserImage(User $user){

        $credentials = ['image_url' => 'http://localhost:8000/storage/images/userDefaultImage.png'];

        $user->update($credentials);

        return response()->json([
            'message' => 'image deleted successfully',
        ]);
    }

    public function deleteSelfImage(){
        $user = JWTAuth::user();

        $credentials = ['image_url' => 'http://localhost:8000/storage/images/userDefaultImage.png'];

        $user->update($credentials);

        return response()->json([
            'message' => 'image deleted successfully',
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
