<?php

namespace App\Http\Controllers\sys_admin;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:role-view|role-full', ['only' => [
            'index',
            'view',
        ]]);
        $this->middleware('permission:role-full', ['only' => [
            'create',
            'store',
            'update',
            'edit',
        ]]);
    }

    public function index(Request $request): View
    {
        $role_type = '';

        $role = DB::table('roles AS r')
            ->leftJoin('model_has_roles AS mhr', 'r.id', '=', 'mhr.role_id')
            ->select('r.id', 'mhr.role_id', 'r.name', DB::raw('COUNT(mhr.role_id) AS role_count'))
            ->groupBy('r.id', 'r.name', 'mhr.role_id');

        if ($request->_role_type) {
            $role = $role->orWhere('r.name', 'like', '%'.$request->_role_type.'%');
            $role_type = $request->_role_type;
        }

        $role = $role->get();

        return view('roles.index', compact('role', 'role_type'));
    }

    public function create(): View
    {
        $permissionname = DB::table('permissions as per')
            ->select('per.name', 'per.id', 'per.display_name')
            ->orderBy('per.name', 'ASC')
            ->get();

        return view('roles.create', compact('permissionname'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_name' => 'required|unique:roles,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        $permission_id = $request->input('permission_id', []);
        $errors = [];
        $loopCount = 1;
        $seen = [];

        foreach ($permission_id as $perm_id) {
            if (in_array($perm_id, $seen)) {
                $errors[$loopCount.'_permission_id'] = ['Duplicate permissions found.'];
            } else {
                $seen[] = $perm_id;
            }

            if ($perm_id === null) {
                $errors[$loopCount.'_permission_id'] = ['Permission required.'];
            }
            $loopCount++;
        }

        if (! empty($errors)) {
            return response()->json([
                'success' => false,
                'errors' => $errors,
            ], 400);
        }

        $role = new Role;
        $role->name = $request->input('role_name');
        $role->updated_at = null;
        $role->guard_name = 'web';
        $role->created_by = auth()->user()->id;
        $role->save();

        $role_id = $role->id;
        $created_by = auth()->user()->id;
        $update = null;

        $termsData = [];

        foreach ($request->input('permission_id') as $key => $value) {
            $termsData[] = [
                'permission_id' => $value,
                'role_id' => $role_id,
                'created_by' => $created_by,
                'created_at' => Carbon::now(),
                'updated_at' => $update,
            ];
        }

        DB::table('role_has_permissions')->insert($termsData);

        session()->flash('success', 'Roles successfully created!.');

        return response()->json(['success' => true], 200);
    }

    public function view(Request $request)
    {
        $roles = DB::table('role_has_permissions as rhp')
            ->join('permissions as p', 'rhp.permission_id', '=', 'p.id')
            ->join('roles as r', 'rhp.role_id', '=', 'r.id')
            ->select('r.name as rname', 'p.name as pname', 'r.id as role_id')
            ->where('role_id', $request->_role)->first();

        $role = DB::table('role_has_permissions as rhp')
            ->join('permissions as p', 'rhp.permission_id', '=', 'p.id')
            ->join('roles as r', 'rhp.role_id', '=', 'r.id')
            ->groupBy('pname', 'p.id', 'p.display_name')
            ->select('p.name as pname', 'p.id', 'p.display_name')
            ->where('r.id', $request->_role)
            ->get();

        return view('roles.view', compact('roles', 'role'));
    }

    public function edit(Request $request)
    {
        $roles = DB::table('role_has_permissions as rhp')
            ->join('permissions as p', 'rhp.permission_id', '=', 'p.id')
            ->join('roles as r', 'rhp.role_id', '=', 'r.id')
            ->select('r.name as rname', 'p.name as pname', 'r.id as role_id')
            ->where('role_id', $request->_role)->first();

        $role = DB::table('role_has_permissions as rhp')
            ->join('permissions as p', 'rhp.permission_id', '=', 'p.id')
            ->join('roles as r', 'rhp.role_id', '=', 'r.id')
            ->groupBy('pname', 'p.id', 'p.display_name')
            ->select('p.name as pname', 'p.id', 'p.display_name')
            ->where('r.id', $request->_role)
            ->get();

        $permissionname = DB::table('permissions as per')
            ->select('per.name', 'per.id', 'per.display_name')
            ->orderBy('per.name', 'ASC')
            ->get();

        return view('roles.edit', compact('roles', 'role', 'permissionname'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role_name' => 'required',
            'permission_id' => 'array',
        ]);

        $permission_id = $request->input('permission_id', []);
        $errors = [];
        $loopCount = 0;
        $seen = [];

        foreach ($permission_id as $perm_id) {
            if (in_array($perm_id, $seen)) {
                $errors[$loopCount.'_permission_id'] = ['Duplicate permissions found.'];
            } else {
                $seen[] = $perm_id;
            }

            if ($perm_id === null) {
                $errors[$loopCount.'_permission_id'] = ['Permission required.'];
            }
            $loopCount = $loopCount + 1;
        }

        if (! empty($errors)) {
            return response()->json([
                'success' => false,
                'errors' => $errors,
            ], 400);
        }

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        $roles = Role::where('id', $request->_role)->first();
        $roles->name = $request->input('role_name');
        $roles->updated_by = auth()->user()->id;
        $roles->save();

        // $permissions = $request->input('permission_id', []);
        // $permissionsModels = Permission::whereIn('id', $permissions)->get();
        // $roles->syncPermissions($permissionsModels);

        $permissionIds = $request->input('permission_id', []);
        $user_id = auth()->user()->id;

        $permissionsModels = Permission::whereIn('id', $permissionIds)->get();

        $roles->syncPermissions($permissionsModels);

        foreach ($permissionsModels as $permission) {
            $permission->updated_by = $user_id;
            $permission->created_by = $user_id;
            $permission->save();
        }
        session()->flash('success', 'Roles successfully updated!.');

        return response()->json(['success' => true], 200);
    }

    // public function destroy($id): RedirectResponse
    // {
    //     DB::table('roles')->where('id', $id)->delete();

    //     return redirect()->route('roles.index')
    //         ->with('success', 'Role deleted successfully');
    // }
}
