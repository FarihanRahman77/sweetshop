<?php

namespace App\Http\Controllers\Admin\SetupManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setups\CompanySetting;
use App\Models\Setups\SisterConcernsWarehouse;
use Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class SisterConcernController extends Controller
{
    

    public function index(){
        return view('admin.setup.sisterConcern.sisterConcernView');
    }


    public function getSisterConcern()
    {
        $data = "";
        $sisterConcerns = CompanySetting::where('deleted', 'No')->orderBy('id', 'DESC')->get();
        $output = array('data' => array());
        $i = 1;
        foreach ($sisterConcerns as $sisterConcern) {
            $status = "";
            if ($sisterConcern->status == 'Active') {
                $status = '<center><i class="fas fa-check-circle" style="color:green; font-size:16px;" title="' . $sisterConcern->status . '"></i></center>';
            } else {
                $status = '<center><i class="fas fa-times-circle" style="color:red; font-size:16px;" title="' . $sisterConcern->status . '"></i></center>';
            }
            $imageUrl = url('upload/images/' . $sisterConcern->logo);
            /* $button = '<button type="button" onclick="editCategory('.$sisterConcern->id.')" class="btn btn-xs btn-warning btnEdit" title="Edit Record" ><i class="fa fa-edit"> </i></button>
                        <button type="button" title="Delete" id="delete" class="btn btn-xs btn-danger btnDelete" onclick="confirmDelete('.$sisterConcern->id.')" title="Delete Record"><i class="fa fa-trash"> </i></button>'; */
            $button = '<td style="width: 12%;">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-cog"></i>  <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu">
                                <li class="action" onclick="editSisterConcern(' . $sisterConcern->id . ')"  ><a  class="btn" ><i class="fas fa-edit"></i> Edit </a></li>
                                
                                <li class="action"><a   class="btn"  onclick="confirmDelete(' . $sisterConcern->id . ')" ><i class="fas fa-trash-alt"></i> Delete </a></li>
                              
                                </ul>
                            </div>
                        </td>';

            $output['data'][] = array(
                $i++ . '<input type="hidden" name="id" id="id" value="' . $sisterConcern->id . '" />',
                '<img style="width:70px;" src="' . $imageUrl . '" alt="' . $sisterConcern->name . '" />',
                $sisterConcern->name,
                $sisterConcern->is_admin,
                $status,
                $button
            );
        }
        return $output;
    }


    public function store(Request $request)
    {
        

        $request->validate([
            'name' => 'required|max:255|unique:tbl_settings_company_settings,name|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u'
        ]);
        if ($request->hasFile('image')) {
            $request->validate([
                'image'   =>  'image|max:2048'
            ]);
            $sisterConcernImage = $request->file('image');
            $name = $sisterConcernImage->getClientOriginalName();
            $uploadPath = 'upload/images/';
            $imageUrl = $uploadPath . $name;
            $imageName = time() . $name;
            $sisterConcernImage->move($uploadPath, $imageName);
        } else {
            $imageName = "no_image.png";
        }
        DB::beginTransaction();
		try {

        $CompanySetting = new CompanySetting();
        $CompanySetting->name = $request->name;
        $CompanySetting->logo = $imageName;
        $CompanySetting->is_admin = 'No';
        $CompanySetting->created_by = auth()->user()->id;
        $CompanySetting->created_date = date('Y-m-d H:i:s');
        $CompanySetting->deleted = 'No';
        $CompanySetting->status = 'Active';
        $CompanySetting->save();
        
        $assigns= new SisterConcernsWarehouse();
        $assigns->sister_concern_id=$CompanySetting->id;
        $assigns->building_id='0';
        $assigns->floor_id='0';
        $assigns->warehouse_id='0';
        $assigns->status="Active";
        $assigns->deleted="No";
        $assigns->created_by = auth()->user()->id;
        $assigns->created_date = date('Y-m-d H:i:s');
        $assigns->save();

        DB::commit();
            return response()->json(['success' => 'Sister Concern saved successfully']);
		} catch (Exception $e) {
			DB::rollBack();
			return response()->json(['error' => 'Sister Concern rollBack!']);
		}
    }




    public function edit(Request $request){
        $companySetting=CompanySetting::find($request->id);
        return $companySetting;
    }


    public function update(Request $request){
        $request->validate([
            'name' => 'required|max:255|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u|unique:tbl_settings_company_settings,name,' . $request->id
        ]);
        $sisterConcern = CompanySetting::find($request->id);
        $sisterConcern->name = $request->name;
        
        if ($request->removeImage == "1") {
            $sisterConcern->logo = "no_image.png";
        } else if ($request->hasFile('image')) {
            $request->validate([
                'image'   =>  'image|max:2048'
            ]);
            $sisterConcernImage = $request->file('image');
            $name = $sisterConcernImage->getClientOriginalName();
            $uploadPath = 'upload/images/';
            $imageUrl = $uploadPath . $name;
            $imageName = time() . $name;
            $sisterConcernImage->move($uploadPath, $imageName);
            $sisterConcern->logo = $imageName;
        }

        $sisterConcern->status = $request->status;
        $sisterConcern->updated_by = auth()->user()->id;
        $sisterConcern->updated_date = date('Y-m-d H:i:s');
        $sisterConcern->save();
        return response()->json(['success' => 'Sister Concern updated successfully']);
    }



    public function delete(Request $request)
    {
        $sisterConcern = CompanySetting::find($request->id);
        $sisterConcern->deleted = 'Yes';
        $sisterConcern->status = 'Active';
        $sisterConcern->name = $sisterConcern->name . '-Deleted-' . $request->id;
        $sisterConcern->deleted_by = auth()->user()->id;
        $sisterConcern->deleted_date = date('Y-m-d H:i:s');
        $sisterConcern->save();
        return response()->json(['success' => 'Sister Concern deleted successfully','message'=>'success']);
    }







}
