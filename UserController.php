<?php

class UserController extends Controller
{
    use UploadController;

    public function __construct(
        protected UserService $service,
    )
    {}

    public function index()
    {
        $users = $this->service->getAll();
        return view('admin.template.user.user-list', compact('users'));
    }

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
}
