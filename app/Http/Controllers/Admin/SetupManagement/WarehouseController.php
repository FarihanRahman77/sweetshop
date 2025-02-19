<?php

namespace App\Http\Controllers\Admin\SetupManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setups\Warehouse;
use App\Models\Setups\SisterConcernsWarehouse;
use App\Models\Setups\CompanySetting;
use Auth;
use Validator;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    // Start Warehouse
    public function warehouse()
    {
       
        $sisterConcerns=CompanySetting::where('deleted','=','No')->where('status','=','Active')->get();
        return view('admin.setup.warehouse.warehouse',['sisterConcerns'=>$sisterConcerns]);
    }

    public function getWarehouses()
    {
        $warehouses = DB::table('tbl_setups_warehouses')
            ->where('tbl_setups_warehouses.deleted', 'No')
            ->orderBy('tbl_setups_warehouses.id', 'DESC')
            ->get();
        $output = array('data' => array());
        $i = 1;
        foreach ($warehouses as $warehouse) {
            $sisterConcerns=SisterConcernsWarehouse::
                leftjoin('tbl_settings_company_settings','tbl_settings_company_settings.id','=','tbl_setups_sister_concern_to_warehouses.sister_concern_id')
                ->select('tbl_setups_sister_concern_to_warehouses.*','tbl_settings_company_settings.name','tbl_settings_company_settings.deleted','tbl_settings_company_settings.status')
                ->where('tbl_setups_sister_concern_to_warehouses.deleted','=','No')
                ->where('tbl_setups_sister_concern_to_warehouses.status','=','Active')
                ->where('tbl_settings_company_settings.deleted','=','No')
                ->where('tbl_settings_company_settings.status','=','Active')
                ->where('tbl_setups_sister_concern_to_warehouses.warehouse_id','=',$warehouse->id)
                ->get();
            $sisterConcernsName='';
            $a=1;
            foreach($sisterConcerns as $sisterConcern){
                $sisterConcernsName .= '<b>'.$a++.' .</b> '.$sisterConcern->name .'<br>';
            }
            $status = "";
            if ($warehouse->status == 'Active') {
                $status = '<center><i class="fas fa-check-circle" style="color:green; font-size:16px;"></i></center>';
            } else {
                $status = '<center><i class="fas fa-times-circle" style="color:red; font-size:16px;"></i></center>';
            }

            $button = '<td style="width: 12%;">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-cog"></i>  <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu">
                                <li class="action liDropDown" onclick="editWarehouse(' . $warehouse->id . ')"  ><a  class="btn" ><i class="fas fa-edit"></i> Edit </a></li>
                                </li>
                            </li>
                                <li class="action liDropDown"><a   class="btn"  onclick="confirmDelete(' . $warehouse->id . ')" ><i class="fas fa-trash-alt"></i> Delete </a></li>
                                </li> 
                                </ul>
                            </div>
                        </td>';

            $output['data'][] = array(
                $i++ . '<input type="hidden" name="id" id="id" value="' . $warehouse->id . '" />',
                $warehouse->name,
                $sisterConcernsName,
                // $warehouse->ware_house_address,
                $status,
                $button
            );
        }
        return $output;
    }

    public function storeWarehouse(Request $request)
    {      


        // return $request;
        $request->validate([
            // 'name'     =>  'required|unique:tbl_setups_warehouses,name|max:255|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'sisterConcern_id'  =>  'required',
            'description'       =>  'nullable|max:500|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
        ]);

        DB::beginTransaction();
		try {
                $warehouse = new Warehouse();
                $warehouse->name = $request->warehouseName;
                $warehouse->description = $request->description;
                $warehouse->type = 'warehouse';
                $warehouse->created_by  = auth()->user()->id;
                $warehouse->created_date  = date('Y-m-d H:i:s');
                $warehouse->save();
                $warehouseId=$warehouse->id;
                $sisterConcernIds=explode(",",$request->sisterConcern_id);
                $i=0;
                foreach($sisterConcernIds as $sisterConcernId){
                    $sisterConcernWarehouse= new SisterConcernsWarehouse();
                    $sisterConcernWarehouse->sister_concern_id=$sisterConcernId[$i];
                    $sisterConcernWarehouse->warehouse_id=$warehouseId;
                    $sisterConcernWarehouse->status='Active';
                    $sisterConcernWarehouse->deleted='No';
                    $sisterConcernWarehouse->created_by=auth()->user()->id;
                    $sisterConcernWarehouse->save();
                }
                
            
            DB::commit();
			return response()->json("Warehouse saved successfulluy!");
		} catch (Exception $e) {
			DB::rollBack();
			return response()->json(['error' => 'Warehouse rollBack!']);
		}
    }






    public function editWarehouse(Request $request)
    {
        $warehouse = Warehouse::find($request->id);
        $data='';
        $sisterConcerns=SisterConcernsWarehouse::
                leftjoin('tbl_settings_company_settings','tbl_settings_company_settings.id','=','tbl_setups_sister_concern_to_warehouses.sister_concern_id')
                ->select('tbl_setups_sister_concern_to_warehouses.*','tbl_settings_company_settings.name','tbl_settings_company_settings.deleted','tbl_settings_company_settings.status')
                ->where('tbl_setups_sister_concern_to_warehouses.deleted','=','No')
                ->where('tbl_setups_sister_concern_to_warehouses.status','=','Active')
                ->where('tbl_settings_company_settings.deleted','=','No')
                ->where('tbl_settings_company_settings.status','=','Active')
                ->where('tbl_setups_sister_concern_to_warehouses.warehouse_id','=',$request->id)
                ->get();
        $allSisterConcerns=CompanySetting::where('deleted','=','No')->where('status','=','Active')->get();
            $sisterConcernsName='';
            $a=1;
            foreach($sisterConcerns as $sisterConcern){
                $sisterConcernsName .= '<option value="'.$sisterConcern->sister_concern_id .'"selected>'. $sisterConcern->name .'</option>';
            }
             foreach($allSisterConcerns as $sisterConcern){
                $sisterConcernsName .= '<option value="'.$sisterConcern->id .'">'. $sisterConcern->name .'</option>';
            } 
            $data=array(
                'warehouse'=>$warehouse,
                'sisterConcernsName'=>$sisterConcernsName
            );
        return $data;
    }

    public function updateWarehouse(Request $request)
    {
       
        $request->validate([
            'id' => 'required',
            'warehouseName' => 'required|max:255|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'editSisterConcern_id'=>'required',
            'description' => 'nullable|max:500|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'status' => 'required',
        ]);
        DB::beginTransaction();
		try {
            $warehouse = Warehouse::find($request->id);
            $warehouse->name = $request->warehouseName;
            $warehouse->ware_house_address = $request->description;
            $warehouse->status = $request->status;
            $warehouse->type = 'warehouse';
            $warehouse->updated_by  = auth()->user()->id;
            $warehouse->updated_date  = date('Y-m-d H:i:s');
            $warehouse->save();
            
            $deleteSisterConcernWarehouses=SisterConcernsWarehouse::where('warehouse_id','=',$request->id)
                                        ->where('status','=','Active')
                                        ->where('deleted','=','No')
                                        ->get();
            foreach($deleteSisterConcernWarehouses as $val){
                $sisterConcernWarehouse= SisterConcernsWarehouse::find($val->id);
                $sisterConcernWarehouse->status='Inactive';
                $sisterConcernWarehouse->deleted='Yes';
                $sisterConcernWarehouse->deleted_by=auth()->user()->id;
                $sisterConcernWarehouse->deleted_date=date('Y-m-d H:i:s');
                $sisterConcernWarehouse->save();
            }

            $sisterConcernIds=explode(",",$request->editSisterConcern_id);
            $i=0;
            foreach($sisterConcernIds as $sisterConcernId){
                    $sisterConcernWarehouse= new SisterConcernsWarehouse();
                    $sisterConcernWarehouse->sister_concern_id=$sisterConcernId[$i];
                    $sisterConcernWarehouse->warehouse_id=$request->id;
                    $sisterConcernWarehouse->status='Active';
                    $sisterConcernWarehouse->deleted='No';
                    $sisterConcernWarehouse->created_by=auth()->user()->id;
                    $sisterConcernWarehouse->save();
                
            }
            DB::commit();
            return response()->json("Warehouse updated successfulluy!");
		} catch (Exception $e) {
			DB::rollBack();
			return response()->json(['error' => 'Warehouse rollBack!']);
		}
    }

    public function deleteWarehouse(Request $request)
    {
        DB::beginTransaction();
		try {
        $warehouse = Warehouse::find($request->id);
        $warehouse->name = $warehouse->name . 'Deleted' . $request->id;
        $warehouse->deleted = 'Yes';
        $warehouse->deleted_by  = auth()->user()->id;
        $warehouse->deleted_date  = date('Y-m-d H:i:s');
        $warehouse->save();
        $deleteSisterConcernWarehouses=SisterConcernsWarehouse::where('warehouse_id','=',$request->id)
                                        ->where('status','=','Active')
                                        ->where('deleted','=','No')
                                        ->get();
            foreach($deleteSisterConcernWarehouses as $val){
                $sisterConcernWarehouse= SisterConcernsWarehouse::find($val->id);
                $sisterConcernWarehouse->status='Inactive';
                $sisterConcernWarehouse->deleted='Yes';
                $sisterConcernWarehouse->deleted_by=auth()->user()->id;
                $sisterConcernWarehouse->deleted_date=date('Y-m-d H:i:s');
                $sisterConcernWarehouse->save();
            }
       
            DB::commit();
        return response()->json("Warehouse Delete successfulluy!");
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Warehouse rollBack!']);
        }
    }
    // End Warehouse Section
}
