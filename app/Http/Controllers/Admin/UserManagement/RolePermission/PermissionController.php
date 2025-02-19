<?php

namespace App\Http\Controllers\Admin\UserManagement\RolePermission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\permission;

use function GuzzleHttp\Promise\all;

class PermissionController extends Controller
{

   /*  function __construct()
    {
         $this->middleware('permission:permission.view|permission.store|permission.delete', ['only' => ['index']]);
         $this->middleware('permission:permission.store', ['only' => ['store']]);
         $this->middleware('permission:permission.edit', ['only' => ['edit', 'update']]);
         $this->middleware('permission:permission.delete', ['only' => ['delete']]);
    } */

    public function index(){
        $permissions=Permission::where('deleted','=','No')->get();
        return view('admin.user.RolesPermissions.permission.permissionView',['permissions'=>$permissions]);
    }

    public function store(Request $request)
    {
        $permissionExist = Permission::where('group_name', $request->group_name)->first();
        
        $permissions = Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
            'deleted'=> 'No',
            'status'    => 'Active',
            ]);

        return redirect('permission/view')->with('message',$request->name. ' saved sucessfully');
    }




    public function edit(Request $request){
        $permissions=Permission::find($request->id);
        return $permissions;
    }

    public function update(Request $request){
            $permissions=Permission::find($request->editId);
            $permissions->name=$request->editName;
            $permissions->group_name=$request->editGroup_name;
            
            $permissions->updated_by=auth()->user()->id;
            $permissions->save();
            return redirect('permission/view')->with('message',$request->name. ' updated sucessfully');
    }




    public function delete($id){
        $permissions=Permission::find($id);
        $permissions->deleted='Yes';
        $permissions->status='Inactive';
        $permissions->deleted_by=auth()->user()->id;
        $permissions->save();
        return redirect('permission/view')->with('message','Permission deleted sucessfully');
    }







}
