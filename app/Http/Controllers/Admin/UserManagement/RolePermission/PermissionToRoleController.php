<?php

namespace App\Http\Controllers\Admin\UserManagement\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\permission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermissionToRoleController extends Controller
{

   /*  function __construct()
    {
        $this->middleware('permission:permissionToRole.view', ['only' => ['index', 'getPermission']]);
        $this->middleware('permission:permissionToRole.store', ['only' => ['store']]);
        $this->middleware('permission:permissionToRole.delete', ['only' => ['delete']]);
    } */

    public function index()
    {
        $permissions = Permission::where('deleted', '=', 'No')->get();
        $roles = Role::where('deleted', '=', 'No')->get();
        $permission_groups = User::getPermissionGroups();
        return view('admin.user.RolesPermissions.permission.permissionToRoleList', ['permissions' => $permissions, 'roles' => $roles, 'permission_groups' => $permission_groups]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required'
        ]);
        
        $role = Role::find($request->role_id);
        $permissions = $request->input('permissions');
        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
            return  redirect('permission/to/role/view')->with('message', 'Permission Assigned sucessfully');
        }
    }


    public function getPermission(Request $request)
    {
        $permissions = DB::table('role_has_permissions')
            ->leftjoin('permissions', 'permissions.id', '=', 'role_has_permissions.permission_id')
            ->select('role_has_permissions.*', 'permissions.name as permissionName')
            ->where('role_has_permissions.role_id', '=', $request->id)
            ->get();


        return $permissions;
    }
}
