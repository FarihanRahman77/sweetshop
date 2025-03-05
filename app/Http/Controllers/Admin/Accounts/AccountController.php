<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Accounts\ChartOfAccounts;
use App\Models\inventory\Warehouse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{

    public function index()
    {
        $loggedWarehouseId=Session::get('warehouse')[0]['id'];
        $coas = ChartOfAccounts::where('deleted', '=', 'No')->where('status', '=', 'Active')->where('warehouse_id','like',"%$loggedWarehouseId%")->orderBy('code', 'asc')->get();
        $warehouses=Warehouse::where('deleted', 'No')->where('status','=','Active')->get();
        return view('admin.account.chartOfAccount', ['coas' => $coas,'warehouses'=>$warehouses]);
    }



    public function getCOA()
    {
        $loggedWarehouseId=Session::get('warehouse')[0]['id'];
        $coas = ChartOfAccounts::leftjoin('tbl_warehouse','tbl_warehouse.id','=','tbl_acc_coas.warehouse_id')
                                ->select('tbl_acc_coas.*','tbl_warehouse.wareHouseName')
                                ->where('tbl_acc_coas.deleted', '=', 'No')
                                ->where('tbl_acc_coas.warehouse_id','like',"%$loggedWarehouseId%")
                                ->orderBy('tbl_acc_coas.code', 'asc')
                                ->get();
        $output = array('data' => array());
        $i = 1;
        foreach ($coas as $coa) {
            $status = "";
            if ($coa->status == 'Active') {
                $status = '<center><i class="fas fa-check-circle" style="color:green; font-size:16px;" title="' . $coa->status . '"></i></center>';
            } else {
                $status = '<center><i class="fas fa-times-circle" style="color:red; font-size:16px;" title="' . $coa->status . '"></i></center>';
            }
           if(Auth::guard('web')->user()->can('coa.edit')){
			    $editDisplay='d-block';
			}else{
			    $editDisplay='d-none';
			}
           if(Auth::guard('web')->user()->can('coa.delete')){
			    $deleteDisplay='d-block';
			}else{
			    $deleteDisplay='d-none';
			}
            $button = '<div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-cog"></i>  <span class="caret"></span></button>
                            <ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu">
                                <li class="action '.$editDisplay.'"><a href="#/" onclick="editCOA(' . $coa->id . ')" class="btn"><i class="fas fa-edit"></i> Edit </a></li>
                                <li class="action '.$deleteDisplay.'"><a href="#/" class="btn" onclick="confirmDelete(' . $coa->id . ')"><i class="fas fa-trash"></i> Delete </a></li>
                                
                            </ul>
                        </div>';
            if ($coa->parent_id == '0') {
                $text = "font-weight-bold";
            } else {
                $text = "font-weight-normal";
            }
            $output['data'][] = array(
                $i++ . '<input type="hidden" name="id" id="id" value="' . $coa->id . '" />',
                '<span class=' . $text . '>' . $coa->name . '</span>',
                $coa->code,
                '<b>Amount: </b>'.$coa->amount,
                $coa->wareHouseName,
                $status,
                $button
            );
        }
        return $output;
    }




    public function getCodeRange(Request $request)
    {
        $ranges = ChartOfAccounts::find($request->parent_id);
        return $ranges;
    }


    public function getCoaCode(Request $request){
       // return $request->parent_id;
        $parent = ChartOfAccounts::find($request->parent_id);
        $parentCode = $parent->our_code;
        $trimedParentCode = rtrim($parentCode, '0');
        $bStart = $trimedParentCode . '01';
        $bEnd = $trimedParentCode . '99';

        $startRange = str_pad($bStart, 9, "0");
        $endRange = str_pad($bEnd, 9, "0");
        //$b=1;
        $assets = ChartOfAccounts::where('deleted', '=', 'No')
            ->where('status', '=', 'Active')
            ->where('parent_id', '=', $request->parent_id)
            ->max('our_code');
        if ($assets == null) {
            $code = str_pad(($trimedParentCode . '01'), 9, "0");
        } else {
            $code = rtrim($assets, '0');
            $code++;
            $code = str_pad($code, 9, "0");
        }
        return $code;
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'slug' => 'required',
            'code' => 'numeric|required',
            'parent_id' => 'numeric|required',
            'warehouse_id' => 'numeric|required'
        ]);
        DB::beginTransaction();
		try {
        $coas = new ChartOfAccounts();
        $coas->name = $request->name;
        $coas->slug = $request->slug;
        $coas->code = $request->code;
        $coas->parent_id = $request->parent_id;
        $coas->warehouse_id = $request->warehouse_id;

        if ($request->parent_id == "0" || $request->parent_id == 'null') {
            $assetCode = '';
            $assets = DB::table('tbl_acc_coas')
                ->select(DB::raw('IFNULL(MAX(substr(our_code, 1,1)),0)+1 as code'))
                ->WHERE('parent_id', '0')
                ->WHERE('deleted', 'No')
                ->where('warehouse_id','=',$request->warehouse_id)
                ->get();
           
            foreach ($assets as $asset) {
                $assetCode = $asset->code;
            }
            if ($assetCode < 10) {
                $trimedAsset = str_pad($assetCode, 9, "0");
            } else {
                return 'Its not possible to generate more then 9 nonparent chart of accounts head';
            }
        } else {
            $parent = ChartOfAccounts::find($request->parent_id);
            $parentCode = $parent->our_code;
            $trimedParentCode = rtrim($parentCode, '0');
            $bStart = $trimedParentCode . '01';
            $bEnd = $trimedParentCode . '99';

            $startRange = str_pad($bStart, 9, "0");
            $endRange = str_pad($bEnd, 9, "0");
            //$b=1;
            $assets = ChartOfAccounts::where('deleted', '=', 'No')
                ->where('status', '=', 'Active')
                ->where('parent_id', '=', $request->parent_id)
                ->where('warehouse_id','=',$request->warehouse_id)
                ->max('our_code');

            if ($assets == null) {
                $trimedAsset = str_pad(($trimedParentCode . '01'), 9, "0");
            } else {
                $trimedAsset = rtrim($assets, '0');
                $trimedAsset++;
                $trimedAsset = str_pad($trimedAsset, 9, "0");
            }
        }

        $coas->our_code = $trimedAsset;
        if ($request->parent_id == '0') {
            $coas->unused = "No";
        } else {
            $coas->unused = "Yes";
        }
        $coas->deleted = "No";
        $coas->status = "Active";
        $coas->created_by = Auth::user()->id;
        $coas->save();
        if ($request->parent_id != '0') {
            $change_parents_status = ChartOfAccounts::find($request->parent_id);
            $change_parents_status->unused = "No";
            $change_parents_status->save();
        }

            DB::commit();
            return response()->json(['success' => $request->name . ' saved successfully']);
            
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Purchase rollBack!']);
        }
        
    }







    public function edit(Request $request)
    {
        $coas = ChartOfAccounts::find($request->id);

        return $coas;
    }


    public function update(Request $request)
    {
        
        $request->validate([
            'name' => 'required|max:255|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'slug' => 'required',
            'code' => 'numeric|required',
            'parent_id' => 'numeric|required',
            'warehouse_id' => 'numeric|required'
        ]);

        $coas = ChartOfAccounts::find($request->id);
        $coas->name = $request->name;
        $coas->slug = $request->slug;
        $coas->code = $request->code;
        $coas->parent_id = $request->parent_id;
        $coas->warehouse_id = $request->warehouse_id;
        if ($request->status) {
            $coas->status = $request->status;
        }
        $coas->last_updated_by = Auth::user()->id;
        $coas->save();
        return response()->json(['success' => $request->name . ' saved successfully']);
    }





    public function delete(Request $request)
    {

        $coas = ChartOfAccounts::find($request->id);
        $coas->status = 'Inactive';
        $coas->deleted = 'Yes';
        $coas->deleted_date = date('Y-m-d h:s');
        $coas->deleted_by = Auth::user()->id;
        $coas->save();


        return response()->json(['success' => 'Deleted successfully']);
    }
}
