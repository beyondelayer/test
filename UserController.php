<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\User\StoreUserRequest;
use App\Http\Requests\Admin\User\UpdateUserRequest;
use App\Models\City;
use App\Models\Country;
use App\Models\User;
use App\Models\UserDetail;
use App\Services\User\UserService;
use App\Traits\UploadController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    use UploadController;

    public function __construct(
        protected UserService $service,
    )
    {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = $this->service->getAll();
        return view('admin.template.user.user-list', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        $countries = Country::all();
        $cities = City::all();
        return view('admin.template.user.add-user', compact('roles', 'countries', 'cities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $userData = $request->only(['name', 'username', 'email', 'password', 'status', 'email_verified_at']);
        $userDetailData = $request->only(['avatar', 'phone', 'address_line_1', 'address_line_2', 'city', 'country', 'district', 'postcode']);

        $userData['email_verified_at'] = $userData['email_verified_at'] == 1 ? now() : null;

        if ($request->filled('avatar') || $request->hasFile('avatar')) {
            $image = $this->uploadImage($request->file('avatar'), 'avatar');
            $userDetailData['avatar'] = $image;
        }

        $user = $this->service->store($userData, $userDetailData);

        $assignRole = Role::where('id', $request->input('role'))->first();
        $user->assignRole($assignRole);

        if (!$user->id) {
            return redirect()->back()->with('error', 'Kullanıcı oluşturulurken bir hata oluştu');
        }

        return redirect()->back()->with('success', 'Kullanıcı başarıyla oluşturuldu');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $countries = Country::all();
        $cities = City::all();
        return view('admin.template.user.edit-user', compact('user', 'roles', 'countries', 'cities'));
    }
}
