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
    // public function __construct()
    // {
    //     $this->middleware('auth:api', ['except' => ['store']]);
    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([User::all()]);
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
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $credentials = [
            'first_name'        => $request->input('first_name'),
            'last_name'         => $request->input('last_name'),
            'email'             => $request->input('email'),
            'password'          => Hash::make($request->input('password')),
            'birth_day'         => $request->input('birth_day'),
            'image_url'   => '/storage/images/userDefaultImage.png'
        ];

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

        if($request->file('image')){
            $path                       = $request->file('image')->store('public/images');
            $url                        = Storage::url($path);
            $credentials['image_url']   = $url;
        }else{
            $credentials['image_url']   = '/storage/images/userDefaultImage.png';
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
    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return response()->json([$user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $credentials = [
            'first_name'        => $request->input('first_name'),
            'last_name'         => $request->input('last_name'),
            'email'             => $request->input('email'),
            'password'          => Hash::make($request->input('password')),
            'birth_day'         => $request->input('birth_day'),
        ];

        if($request->file('image')){
            $path                       = $request->file('image')->store('public/images');
            $url                        = Storage::url($path);
            $credentials['image_url']   = $url;
        }
    }

    public function updateSelf(UpdateUserRequest $request){
        $credentials = [
            'first_name'        => $request->input('first_name'),
            'last_name'         => $request->input('last_name'),
            'email'             => $request->input('email'),
            'birth_day'         => $request->input('birth_day'),
        ];

        if($request->file('image')){
            $path = $request->file('image')->store('public/images');
            $url = Storage::url($path);
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
        $path = $request->file('image')->store('public/images');
        $url = Storage::url($path);
        $credentials['image_url'] = $url;

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

        $path = $request->file('image')->store('public/images');
        $url = Storage::url($path);
        $credentials['image_url'] = $url;

        $user->update($credentials);

        return response()->json([
            'message' => 'image updated successfully',
        ]);
    }

    public function deleteUserImage(User $user){

        $credentials = ['image_url' => '/storage/images/userDefaultImage.png'];

        $user->update($credentials);

        return response()->json([
            'message' => 'image deleted successfully',
        ]);
    }

    public function deleteSelfImage(){
        $user = JWTAuth::user();

        $credentials = ['image_url' => '/storage/images/userDefaultImage.png'];

        $user->update($credentials);

        return response()->json([
            'message' => 'image deleted successfully',
        ]);
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json([
            'message' => 'user deleted successfully',
        ]);
    }
}
