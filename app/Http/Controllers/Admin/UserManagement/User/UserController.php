<?php

namespace App\Http\Controllers\Admin\UserManagement\User;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\permission;
use Image;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class UserController extends Controller
{
    // Check Permission
    /* function __construct()
    {
        $this->middleware('permission:user.view', ['only' => ['index', 'getUsers', 'add']]);
        $this->middleware('permission:user.store', ['only' => ['store']]);
        $this->middleware('permission:user.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user.delete', ['only' => ['delete']]);
        $this->middleware('permission:user.changePassword', ['only' => ['changePassword']]);
    } */

    
    public function index()
    {     
       

        $roles = Role::where('deleted', '=', 'No')->get();
        $sisterConcerns =  CompanySetting::where('deleted', 'No')->where('status', '=', 'Active')->get();
        return view('admin.user.view-users', ['roles' => $roles,'sisterConcerns'=>$sisterConcerns]);
    }

    
    public function getUsers()
    {
        $data = "";
        $users = User::where('deleted', 'No')->orderBy('id', 'DESC')->get();
        $i = 1;
        $output = array('data' => array());
        foreach ($users as $user) {
            /*Load Image*/
            if ($user->image != "") {
                $imageUrl = url('upload/user_images/' . $user->image);
            } else {
                $imageUrl = url('upload/user_images/no_image.png');
            }
            /*Status*/
            if ($user->status == 'Active') {
                $status = '<center><i class="fas fa-check-circle" style="color:green; font-size:16px;"></i></center>';
            } else {
                $status = '<center><i class="fas fa-times-circle" style="color:red; font-size:16px;"></i></center>';
            }
            /*Buttons*/
            /*	$buttonOld = '<button type="button" onclick="userEdit('.$user->id.')" class="btn btn-xs btn-warning btnEdit" title="Edit User" ><i class="fa fa-edit"> </i></button>
                       <button type="button" title="Delete" id="delete" class="btn btn-xs btn-danger btnDelete" onclick="confirmDelete('.$user->id.')" title="Delete User"><i class="fa fa-trash"> </i></button>';
        */


            $button = '<td style="width: 12%;">
            <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                    <i class="fas fa-cog"></i>  <span class="caret"></span></button>
                    <ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu">
                    <li class="action" onclick="userEdit(' . $user->id . ')"><a  class="btn" ><i class="fas fa-edit"></i> Edit </a></li>
                    </li>
                </li>
                    <li class="action"><a   class="btn" onclick="confirmDelete(' . $user->id . ')" ><i class="fas fa-trash-alt"></i> Delete </a></li>
                    </li> 
                    </ul>
                </div>
            </td>';


            $output['data'][] = array(
                $i++ . '<input type="hidden" name="id" id="id" value="' . $user->id . '" />',
                '<img style="width:70px;" src="' . $imageUrl . '" alt="' . $user->name . '" />',
                'Name: '.$user->name.'<br>User Name: '.$user->username,
                $user->email . '<br>' . $user->mobile_no,
                'Dep: ' . $user->department . '<br>Des: ' . $user->designation . '<br><b>Role:</b>' . $user->role,
                $status,
                $button
            );
        }
        return $output;
    }

    


    
    public function store(Request $request)
    {
        //  return $request;
        $request->validate([
            'name' => 'required|max:255|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'username' => 'required|unique:users,username|max:255|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'email' => 'required|unique:users,email|min:3|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'mobile_no' => 'required|unique:users,mobile_no|max:11|min:11|regex:/^(?:\+?88)?01[11-9]\d{8}$/u',
            'usertype_id' => 'required',
            'password' => 'required|min:6',
            'role' => 'required',
            'address' => 'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'designation' => 'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'department' => 'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
        ]);

        $imageName = '';
        if ($request->hasFile('image')) {
            $request->validate([
                'image'   =>  'image|max:2048'
            ]);
       
            $userImage = $request->file('image');
            $name = $userImage->getClientOriginalName();
            $uploadPath = 'upload/user_images/';
            
            $imageName = time() . $name;
            $imageUrl = $uploadPath . $imageName;
         
            Image::make($userImage)->resize(100, 100)->save($imageUrl);
           
            $request->image->move(public_path($uploadPath), $imageName);
        
        } else {
            $imageName = "no_image.png";
        }

        if ($request->hasFile('signature')) {
            /*  $request->validate([
                'signature'   =>  'signature|max:2048'
            ]);
             */

            $userSignature = $request->file('signature');
            $name = $userSignature->getClientOriginalName();
            $uploadPath = 'upload/user_signatures/';
          
            $signatureName = time() . $name;
            $signatureUrl = $uploadPath . $signatureName;
          
            Image::make($userSignature)->resize(100, 100)->save($signatureUrl);
      
            $request->signature->move(public_path($uploadPath), $signatureName);
        
        } else {
            $signatureName = "no_image.png";
        }
        
        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->department = $request->department;
        $user->role = $request->role;
        $user->address = $request->address;
        $user->usertype_id = $request->usertype_id;
        $user->designation = $request->designation;
        $user->mobile_no = $request->mobile_no;
        $user->sister_concern_id = $request->sister_concern_id;
        $user->image = $imageName;
        $user->signature = $signatureName;
        $user->password = Hash::make($request->password);
        $user->created_by = auth()->user()->id;
        $user->created_date = date('Y-m-d H:i:s');
        $user->deleted = 'No';
        $user->save();

        $user->assignRole($request->role);

        return response()->json(['success' => 'User saved successfully']);
    }

    // Edit User
    public function edit(Request $request)
{
    $user = User::find($request->id);
    $sisterConcernArray = []; 
    $sisterConcerns = explode(",", $user->sister_concern_id); // Get selected sister concerns

    // Fetch all sister concerns to display in the dropdown
    $allSisterConcerns = CompanySetting::all(); // Assuming 'CompanySetting' is the model for sister concerns

    foreach ($sisterConcerns as $sisterconcernId) {  
        $sisterconcern = CompanySetting::find($sisterconcernId);  
        if ($sisterconcern) {
            $sisterConcernArray[] = $sisterconcern;  // Store selected sister concerns
        }
    }

    // Return user data, selected sister concerns, and all sister concerns
    return response()->json([
        'user' => $user,
        'sisterConcern' => $sisterConcernArray,
        'allSisterConcerns' => $allSisterConcerns
    ]);
}

    // Update User
    public function update(Request $request)
    { 
        // return $request;
        $request->validate([
            'name' => 'required|max:255|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'username' => 'required|max:255|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'email' => 'required|unique:users,email,' . $request->id . '|min:3|regex:/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix',
            'role' => 'required',
            'mobile_no' => 'required|unique:users,mobile_no,' . $request->id . '|max:14|min:11|regex:/^(?:\+?88)?01[11-9]\d{8}$/u',
            'address' => 'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'designation' => 'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'department' => 'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
        ]);
        $user = User::find($request->id);
        if ($request->file('image')) {
            $request->validate([
                'image'   =>  'image|max:2048'
            ]);

            //--- Image resize And upload in public 
            $oldUserImage = $user->image;
            $userImage = $request->file('image');
            $name = $userImage->getClientOriginalName();
            $uploadPath = 'upload/user_images/';
            $uploadPathOriginal = 'upload/original_user_images/';
            $imageName = time() . $name;
            $imageUrl = $uploadPath . $imageName;
            $imageOriginalUrl = $uploadPathOriginal . time() . $name;
            //--resize image upload in public--//
            Image::make($userImage)->resize(100, 100)->save($imageUrl);
            //--original image upload in public--//
            $request->image->move(public_path($uploadPathOriginal), $imageName);

            $user->image = $imageName;
        }


        if ($request->file('signature')) {

            //--- Image resize And upload in public 
            $oldUserSignature = $user->signature;
            $userSignature = $request->file('signature');
            $name = $userSignature->getClientOriginalName();
            $uploadPath = 'upload/user_signatures/';
            $uploadPathOriginal = 'upload/original_user_signatures/';
            $signatureName = time() . $name;
            $signatureUrl = $uploadPath . $signatureName;
            $signatureOriginalUrl = $uploadPathOriginal . time() . $name;
            //--resize signature upload in public--//
            Image::make($userSignature)->resize(100, 100)->save($signatureUrl);
            //--original signature upload in public--//
            $request->signature->move(public_path($uploadPathOriginal), $signatureName);

            $user->signature = $signatureName;
        }

        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->designation = $request->designation;
        $user->department = $request->department;
        $user->address = $request->address;
        $user->sister_concern_id = $request->sister_concern_id;
        $user->mobile_no = $request->mobile_no;
        $user->status = $request->status;
        $user->updated_by = auth()->user()->id;
        $user->updated_date = date('Y-m-d H:i:s');
        $user->save();


        $user->roles()->detach();
        if ($request->role) {
            $user->assignRole($request->role);
        }

        return response()->json(['success' => 'User updated successfully']);
    }

    // Delete User
    public function delete(Request $request)
    {
        $user = User::find($request->id);
        $user->deleted = 'Yes';
        $user->name = $user->name . 'Deleted' . $request->id;
        $user->username = $user->username . 'Deleted' . $request->id;
        $user->email = $user->email . 'Deleted' . $request->id;
        $user->mobile_no = $user->mobile_no . 'Deleted' . $request->id;
        $user->deleted_by = auth()->user()->id;
        $user->deleted_date = date('Y-m-d H:i:s');
        $user->save();
        return response()->json(['Success' => 'Deleted successfully']);
    }

    // Change User Password 
    public function changePassword(Request $request)
    {
        $password = Hash::make($request->password);

        $user = User::find($request->userId);
        $user->password = $password;
        $user->updated_by = auth()->user()->id;
        $user->updated_date = Carbon::now();
        $user->save();

        return response()->json(['success' => 'User password updated successfully']);
    }

    public function edit_user_password(){
        return view('admin.user.edit_user_password');
    }


    public function password_update(Request $request){
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|regex:/^([a-zA-Z0-9]*)+$/',
            're_type_password' => 'required|min:6|regex:/^([a-zA-Z0-9]*)+$/',
        ]);
        
            if($request->re_type_password == $request->new_password){
                $user=User::find(auth()->user()->id);
                if (Hash::check($request->old_password, $user->password)) { 
                    $password=Hash::make($request->new_password);
                    $user->password=$password;
                    $user->save();
                    return response()->json(['success' => 'User password updated successfully']);
                }else{
                    return response()->json(['error' => 'Old Password does not match.']);
                }
            }else{
                return response()->json(['error' => 'Re-type the new password correctly.']);
            }
        
        
        
    }







}
