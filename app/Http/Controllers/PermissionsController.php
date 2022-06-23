<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Permission;

class PermissionsController extends Controller
{
    protected $permissionModel;

    public function __construct()
    {
    }

    public function index()
    {
        return View::make('permissions.index', [
            'permissions' => Permission::simplePaginate(10),
        ]);
    }

    public function create()
    {
        
        return View::make('laratrust::panel.edit', [
            'model' => null,
            'permissions' => null,
            'type' => 'permission',
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:roles,name',
            'display_name' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $permission = $this->permissionModel::create($data);
        

        Session::flash('laratrust-success', 'Permission created successfully');
        return redirect(route('laratrust.permissions.index'));
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        return View::make('laratrust::panel.edit', [
            'model' => $permission,
            'type' => 'permission',
        ]);
    }

    public function update(Request $request, $id)
    {
        $permission = $this->permissionModel::findOrFail($id);

        $data = $request->validate([
            'display_name' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $permission->update($data);

        Session::flash('laratrust-success', 'Permission updated successfully');
        return redirect(route('laratrust.permissions.index'));
    }
}
