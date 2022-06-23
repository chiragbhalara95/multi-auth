<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Role;
use App\Permission;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::select('id', 'email', 'name')->get();

        return view('users.list')->with([
            'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::get();
        $permissions = Permission::get();

        return view('users.add', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);
        
        try {
            DB::beginTransaction();
            // Logic For Save User Data

            $create_user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('password')
            ]);

            if(!$create_user){
                DB::rollBack();

                return back()->with('error', 'Something went wrong while saving user data');
            }

            $user = user::find($create_user->id);
            $userRole = Role::find($request->roles);
            if (!$user->hasRole($userRole->slug)){
                DB::table('users_roles')->where('user_id', $create_user->id)->delete();
                $user->roles()->attach($userRole);
            }

            DB::commit();
            return redirect()->route('users.index')->with('success', 'User Stored Successfully.');

        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user =  User::whereId($id)->first();

        if(!$user){
            return back()->with('error', 'User Not Found');
        }

        $roles = Role::get();
        $permissions = Permission::get();

        return view('users.edit')->with([
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email'
        ]);

        try {
            DB::beginTransaction();
            // Logic For Save User Data

            $update_user = User::where('id', $id)->update([
                'name' => $request->name,
                'email' => $request->email
            ]);

            if(!$update_user){
                DB::rollBack();

                return back()->with('error', 'Something went wrong while update user data');
            }

            $user = user::find($id);
            $userRole = Role::find($request->roles);
            if (!$user->hasRole($userRole->slug)){
                DB::table('users_roles')->where('user_id', $id)->delete();
                $user->roles()->attach($userRole);
            }

            DB::commit();
            return redirect()->route('users.index')->with('success', 'User Updated Successfully.');


        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $delete_user = User::whereId($id)->delete();

            if(!$delete_user){
                DB::rollBack();
                return back()->with('error', 'There is an error while deleting user.');
            }

            DB::commit();
            return redirect()->route('users.index')->with('success', 'User Deleted successfully.');



        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
