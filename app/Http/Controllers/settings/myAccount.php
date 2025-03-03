<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class myAccount extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Get the permission names assigned to the user
        $permissionNames = $user->getPermissionNames();

        // Retrieve permissions along with their display names
        $permissions = DB::table('permissions')
            ->whereIn('name', $permissionNames)
            ->get(['name', 'display_name']);

        $roles = $user->getRoleNames();

        return view('settings.myAccount.index', compact('user', 'permissions', 'roles'));
    }

    public function user_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'alias' => 'required|unique:users,alias,'.Auth::id(),
            // 'first_name' => 'required',
            // 'last_name' => 'required',
            'user_profile' => 'image|mimes:jpg,png,jpeg,gif,svg,webp|max:2048',
        ], [
            'alias.unique' => 'The alias has already been taken.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        $user = Auth::user();
        $user->alias = $request->alias;
        $user->user_name = $request->user_name;
        // $user->first_name = $request->first_name;
        // $user->last_name = $request->last_name;

        if ($request->hasFile('user_profile')) {
            if ($user->user_profile) {
                $oldProfileImagePath = public_path($user->user_profile);
                if (file_exists($oldProfileImagePath)) {
                    unlink($oldProfileImagePath);
                }
            }

            $file = $request->file('user_profile');
            $extension = $file->getClientOriginalExtension();
            $filename = time().'.'.$extension;
            $filedirectory = 'assets/userProfile/'.$filename;
            $file->move('assets/userProfile/', $filename);
            $user->user_profile = $filedirectory;
        }

        $user->save();

        session()->flash('success', 'SUCCESS');

        return redirect('settings/myAccount');
    }

    public function user_changepass(Request $request)
    {
        // Validate if all input fields are filled
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required',
            'confirm-password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        // Check if the current password is correct
        $user = Auth::user();
        if (! Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'errors' => ['current_password' => ['Current Password is Invalid']],
            ], 400);
        }

        // Check if the new password and confirm password match
        if ($request->password !== $request->input('confirm-password')) {
            return response()->json([
                'success' => false,
                'errors' => ['confirm-password' => ['New Password and Confirm Password do not match']],
            ], 400);
        }

        // Update the password
        $user->password = Hash::make($request->password);
        $now = Carbon::now();
        $user->last_password_change = Carbon::now();

        $user->next_pwd_change = $now->addMonths(3);
        $user->save();

        return response()->json(['success' => true]);
    }

    public function user_changepass_onlogin(Request $request)
    {
        // Validate if all input fields are filled
        $validator = Validator::make($request->all(), [
            'current_password_l' => 'required',
            'password_l' => 'required',
            'confirm-password_l' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->getMessageBag()->toArray(),
            ], 400);
        }

        // Check if the current password is correct
        $user = Auth::user();
        if (! Hash::check($request->current_password_l, $user->password)) {
            return response()->json([
                'success' => false,
                'errors' => ['current_password_l' => ['Current Password is Invalid']],
            ], 400);
        }

        // Check if the new password and confirm password match
        if ($request->password_l !== $request->input('confirm-password_l')) {
            return response()->json([
                'success' => false,
                'errors' => ['confirm-password_l' => ['New Password and Confirm Password do not match']],
            ], 400);
        }

        // Update the password
        $user->password = Hash::make($request->password_l);
        $now = Carbon::now();
        $user->last_password_change = Carbon::now();

        $user->next_pwd_change = $now->addMonths(3);
        $user->reset_on_login = 0;
        $user->save();
        session()->flash('success', 'Password successfully changed!');

        return response()->json(['success' => true]);
    }
}
