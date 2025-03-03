<?php

namespace App\Http\Controllers\sys_admin;

use App\Models\User;
use DB;
use Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use App\Models\app\org_user_bu;
use App\Models\app\model_has_permissions;
use App\Models\app\model_has_roles;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $bu_id = "";
        $alias = "";
        $email = "";
        $first_name = "";
        $last_name = "";
        $users = [];

        $query = DB::table('users as u')
            ->select(
                'u.id',
                'u.alias',
                'u.first_name',
                'u.last_name',
                'u.email',
                'u.enabled',
                'u.last_login',
            )->orderBy('u.first_name', 'asc');
        // dd($query->get());


        if ($request->has('filter')) {
            if ($request->email) {
                $query->where('u.email', 'like', '%' . $request->email . '%');
                $email = $request->email;
            }

            if ($request->alias) {
                $query->where('u.alias', 'like', '%' . $request->alias . '%');
                $alias = $request->alias;
            }

            if ($request->first_name) {
                $query->where('u.first_name', 'like', '%' . $request->first_name . '%');
                $first_name = $request->first_name;
            }

            if ($request->last_name) {
                $query->where('u.last_name', 'like', '%' . $request->last_name . '%');
                $last_name = $request->last_name;
            }

            // Execute the query and get the results
        }
        $users = $query->get();

        // if (!empty($users)) {
        //     dd("this is users variable", $users);
        // }else {
        //     dd("users is empty", $query->get());
        // }
        return view('users.index', compact('users', 'alias', 'email', 'first_name', 'last_name'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $businessUnits = DB::table('org_business_units')
            ->get();

        $roles = DB::table('roles as rol')
        ->select('rol.name', 'rol.id')
        ->orderBy('rol.name', 'ASC')
        ->get();

        // $permissionname = DB::table('permissions as per')
        //     ->select('per.name', 'per.id')
        //     ->orderBy('per._name', 'ASC')
        //     ->get();

        $permissionname = DB::table('permissions as per')
            ->select('per.name', 'per.id', 'per.display_name')
            ->orderBy('per.display_name', 'ASC')
            ->get();

        // dd(compact('businessUnits','roles', 'roles', 'permissionname'));
        return view('users.create', compact('businessUnits', 'roles', 'permissionname'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'alias' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required',
            'confirmPassword' => 'required|same:password',
            'email' => 'required|email|unique:users,email',
            'enabled' => 'required|accepted|in:on',
            'selected_business_units' => 'required|array',
            'roles' => 'array',
            'permissions' => 'array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        $defaultImageUrl = 'assets/userProfile/default-image.jpg';

        $user = new User();
        $user->alias = $request->input('alias');
        $hashedPassword = Hash::make($request->input('password'));
        $user->password = $hashedPassword;
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $enabledValue = $request->input('enabled') === 'on' ? 1 : 0;
        $user->enabled = $enabledValue;
        $resent_on_loginValue = $request->input('resent_on_login') === 'on' ? 1 : 0;
        $user->reset_on_login = $resent_on_loginValue;
        $user->last_password_change = now();
        $user->next_pwd_change = now()->addDays(90);
        $user->created_by = auth()->user()->id;

        $user->user_profile = $request->input('user_profile', $defaultImageUrl);

        $user->save();

        $user_id = $user->id;
        $model_type = 'App\Models\User';

        $roles = [];
        $roleIds = $request->input('roles');
        $uniqueRoleIds = array_unique($roleIds);
        foreach ($uniqueRoleIds as $roleId) {
            if ($roleId !== null) {
                $roles[] = [
                    'model_id' => $user_id,
                    'model_type' => $model_type,
                    'role_id' => $roleId,
                ];
            }
        }
        if (!empty($roles)) {
            model_has_roles::insert($roles);
        }

        $permissions = [];
        $permissionIds = $request->input('permissions');
        $uniquepermissionIdsIds = array_unique($permissionIds);
        foreach ($uniquepermissionIdsIds as $permissionId) {
            if ($permissionId !== null) {
                $permissions[] = [
                    'model_id' => $user_id,
                    'model_type' => $model_type,
                    'permission_id' => $permissionId,
                ];
            }
        }
        if (!empty($permissions)) {
            model_has_permissions::insert($permissions);
        }

        // Retrieve selected business unit IDs from the request
        $selectedBusinessUnits = $request->input('selected_business_units');
        // Process business unit associations
        $businessUnits = [];
        foreach ($selectedBusinessUnits as $buId) {
            $businessUnits[] = [
                'user_id' => $user_id,
                'bu_id' => $buId,
                'created_by' => auth()->user()->id,
                'enabled' => 1,
                'updated_at' => now(),
            ];
        }
        org_user_bu::insert($businessUnits);

        session()->flash('success', "User Successfully Added!");
        return response()->json(['success' => true], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $user = User::find($id);
        // dd($user);
        return view('users.show', compact('user'));
    }

    public function view(Request $request)
    {
        $businessUnits = DB::table('org_user_bu as ubu')
            ->join('org_business_units as bu', 'ubu.bu_id', '=', 'bu.bu_id')
            ->where('ubu.user_id', auth()->user()->id)
            ->where('ubu.enabled', 1)
            ->orderBy('bu.bu_name', 'ASC')
            ->get();

        $userInfo = DB::table('users')
            ->where('users.id', $request->_user);

        $userInfo = $userInfo->select(
            'users.id',
            'users.alias',
            'users.first_name',
            'users.last_name',
            'users.email',
            'users.enabled',
            'users.last_login',
            'users.last_login_ip',
            'users.reset_on_login',
            'users.last_password_change',
            'users.next_pwd_change'
        )->first();

        $roleInfo = DB::table('model_has_roles as mhr')
            ->join('users as u', 'mhr.model_id', '=', 'u.id')
            ->join('roles as r', 'mhr.role_id', '=', 'r.id')
            ->where('u.id', $request->_user)
            ->orderBy('r.name', 'ASC')
            ->get();

        $perInfo = DB::table('model_has_permissions as mhp')
            ->join('users as u', 'mhp.model_id', '=', 'u.id')
            ->join('permissions as p', 'mhp.permission_id', '=', 'p.id')
            ->where('u.id', $request->_user)
            ->orderBy('p.display_name', 'ASC')
            ->get();

        $businessUnitsInfo = DB::table('org_user_bu as ubu')
            ->join('users as u', 'ubu.user_id', '=', 'u.id')
            ->join('org_business_units as bu', 'ubu.bu_id', '=', 'bu.bu_id')
            ->where('ubu.user_id', $request->_user)
            ->get();

        $tbl_roles = DB::table('roles')
                ->orderBy('name', 'ASC')
                ->get();

        $tbl_permission = DB::table('permissions')
                ->orderBy('display_name', 'ASC')
                ->get();

        $tbl_businessUnit = DB::table('org_business_units')
                ->get();

        $enabledBusinessUnits = DB::table('org_user_bu')
            ->join('org_business_units', 'org_user_bu.bu_id', '=', 'org_business_units.bu_id')
            ->where('org_user_bu.enabled', 1)
            ->where('org_user_bu.user_id', $request->_user)
            ->get();

        return view('sys_admin.users.view', compact('businessUnits', 'userInfo', 'roleInfo', 'perInfo', 'businessUnitsInfo', 'tbl_roles', 'tbl_permission', 'tbl_businessUnit', 'enabledBusinessUnits'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request): View
    {

        $businessUnits = DB::table('org_user_bu as ubu')
            ->join('org_business_units as bu', 'ubu.bu_id', '=', 'bu.bu_id')
            ->where('ubu.user_id', auth()->user()->id)
            ->where('ubu.enabled', 1)
            ->orderBy('bu.bu_name', 'ASC')
            ->get();

        $userInfo = DB::table('users')
            ->where('users.id', $request->_user);

        $userInfo = $userInfo->select(
            'users.id',
            'users.alias',
            'users.first_name',
            'users.last_name',
            'users.email',
            'users.enabled',
            'users.last_login',
            'users.last_login_ip',
            'users.reset_on_login',
            'users.last_password_change',
            'users.next_pwd_change'
        )->first();

        $roleInfo = DB::table('model_has_roles as mhr')
            ->join('users as u', 'mhr.model_id', '=', 'u.id')
            ->join('roles as r', 'mhr.role_id', '=', 'r.id')
            ->where('u.id', $request->_user)
            ->orderBy('r.name', 'ASC')
            ->get();

        $perInfo = DB::table('model_has_permissions as mhp')
        ->join('users as u', 'mhp.model_id', '=', 'u.id')
        ->join('permissions as p', 'mhp.permission_id', '=', 'p.id')
        ->where('u.id', $request->_user)
        ->orderBy('p.display_name', 'ASC')
        ->get();

        $businessUnitsInfo = DB::table('org_user_bu as ubu')
            ->join('users as u', 'ubu.user_id', '=', 'u.id')
            ->join('org_business_units as bu', 'ubu.bu_id', '=', 'bu.bu_id')
            ->where('ubu.user_id', $request->_user)
            ->get();

        $tbl_roles = DB::table('roles')
                ->orderBy('name', 'ASC')
                ->get();

        $tbl_permission = DB::table('permissions')
        ->orderBy('display_name', 'ASC')
        ->get();

        $tbl_businessUnit = DB::table('org_business_units')
                ->get();

        $enabledBusinessUnits = DB::table('org_user_bu')
            ->join('org_business_units', 'org_user_bu.bu_id', '=', 'org_business_units.bu_id')
            ->where('org_user_bu.enabled', 1)
            ->where('org_user_bu.user_id', $request->_user)
            ->get();

        return view('users.edit', compact('businessUnits', 'userInfo', 'roleInfo', 'perInfo', 'businessUnitsInfo', 'tbl_roles', 'tbl_permission', 'tbl_businessUnit', 'enabledBusinessUnits'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $userId = $request->input('user_id');

        $validator = Validator::make($request->all(), [
            'alias' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($userId),
            ],
            'roles' => 'array',
            'permissions' => 'array',
            'business_units_checked' => 'required|array',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        $defaultImageUrl = 'assets/userProfile/cat_image.png';

        $user = User::findOrFail($userId);
        $user->alias = $request->input('alias');
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $enabledValue = $request->input('enabled') === 'on' ? 1 : 0;
        $user->enabled = $enabledValue;
        $resent_on_loginValue = $request->input('resent_on_login') === 'on' ? 1 : 0;
        $user->reset_on_login = $resent_on_loginValue;
        $user->last_password_change = now();
        $user->next_pwd_change = now()->addDays(90);
        $user->updated_at = now();

        $user->user_profile = $request->input('user_profile', $defaultImageUrl);

        $user->save();

        $roles = $request->input('roles', []);
        $user->roles()->sync($roles);

        $permissions = $request->input('permissions', []);
        $user->permissions()->sync($permissions);

        // Process business units
        $businessUnitsChecked = $request->input('business_units_checked', []);
        $businessUnitsUnchecked = $request->input('business_units_unchecked', []);

        foreach ($businessUnitsChecked as $buId) {
            $orgUserBu = org_user_bu::where('user_id', $userId)
                ->where('bu_id', $buId)
                ->first();
            if ($orgUserBu) {
                // Record exists, update it
                DB::table('org_user_bu')
                ->where('user_id', $userId)
                ->where('bu_id', $buId)
                ->update([
                    'enabled' => 1,
                    'updated_by' => auth()->user()->id,
                    'updated_at' => now(),
                ]);
            } else {
                // Record does not exist, create it
                org_user_bu::create([
                    'user_id' => $userId,
                    'bu_id' => $buId,
                    'enabled' => 1,
                    'created_by' => auth()->user()->id,
                    'created_at' => now(),
                ]);
            }
        }

        foreach ($businessUnitsUnchecked as $buId) {
            // Record exists, update it
            DB::table('org_user_bu')
            ->where('user_id', $userId)
            ->where('bu_id', $buId)
            ->update([
                'enabled' => 0,
                'updated_by' => auth()->user()->id,
                'updated_at' => now(),
            ]);
        }

        session()->flash('success', "User Successfully Updated!");
        return response()->json(array('success' => true), 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        User::find($id)->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }

    public function verify_to_changePass()
    {
        $user = DB::table('users')
            ->where('id', auth()->user()->id)
            ->first();

        if ($user->reset_on_login == 1 ||   date('Y-m-d') >= $user->next_pwd_change) {
            return "true";
        } else {
            return "false";
        }
    }

    public function reset_password($user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        return view('users.reset_password', compact('user'));
    }

    public function save_reset_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'new_password' => 'required',
            'confirmed_password' => 'required|same:new_password',
            'reset_on_login' => 'required|in:on',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray()
            ], 400);
        }

        $id = $request->input('user_id');

        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $hashedPassword = Hash::make($request->input('new_password'));
        $user->password = $hashedPassword;
        $enabledValue = $request->input('reset_on_login') === 'on' ? 1 : 0;
        $user->reset_on_login = $enabledValue;
        $user->last_password_change = now();
        $user->next_pwd_change = now()->addDays(90);
        $user->updated_by = auth()->user()->id;
        try {
            $user->save();
            session()->flash('success', 'User Password Successfully Changed.');
            return response()->json(['success' => true], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['error' => 'An error occurred while updating the user. Please try again later.'], 500);
        }
    }
}
