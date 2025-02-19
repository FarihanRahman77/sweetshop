<?php

namespace App\Http\Controllers\Admin\SetupManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setups\Warehouse;
use Illuminate\Support\Facades\Session;
use App\Models\Setups\Category;
use App\Models\inventory\Product;
use App\Models\Setups\Currentstock;
use App\Models\inventory\WarehouseTransfer;
use App\Models\Setups\CompanySetting;
use App\Models\Setups\SisterConcernCategory;
use Auth;
use Validator;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
     /* function __construct()
    {
        $this->middleware('permission:categories.view', ['only' => ['index', 'getCategories', 'add']]);
        $this->middleware('permission:categories.store', ['only' => ['store']]);
        $this->middleware('permission:categories.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:categories.delete', ['only' => ['delete']]);
        // Warehouse
        $this->middleware('permission:warehouse.view', ['only' => ['warehouse', 'getWarehouses']]);
        $this->middleware('permission:warehouse.store', ['only' => ['storeWarehouse']]);
        $this->middleware('permission:warehouse.edit', ['only' => ['editWarehouse', 'updateWarehouse']]);
        $this->middleware('permission:warehouse.delete', ['only' => ['deleteWarehouse']]);
    } */ 

    public function index()
    {
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $sisterConcerns=CompanySetting::where('deleted','=','No')->where('status','=','Active')->get();
        $sisterConcernCategories=SisterConcernCategory::where('tbl_setups_sisterconcern_categories.deleted','=','No')
                    ->where('tbl_setups_sisterconcern_categories.status','=','Active')
                    ->where('tbl_setups_sisterconcern_categories.sister_concern_id','=',$logged_sister_concern_id)
                    ->get();

        return view('admin.setup.category.view-category',['sisterConcerns'=>$sisterConcerns,'sisterConcernCategories'=>$sisterConcernCategories]);
    }


    public function getCategories()
    {
        $categories = Category::leftJoin('tbl_setups_sisterconcern_categories', 'tbl_setups_sisterconcern_categories.category_id', '=', 'tbl_setups_categories.id')
                                ->select('tbl_setups_categories.*',  'tbl_setups_sisterconcern_categories.sort_code') 
                                ->where('tbl_setups_categories.deleted', 'No')
                                ->distinct()
                                ->orderBy('tbl_setups_categories.id', 'DESC')
                                ->get();
     
    
        $output = array('data' => array());
        $i = 1;
    
        foreach ($categories as $category) {
            // Fetch related sister concerns for each category
            $sisterConcerns = SisterConcernCategory::
                leftJoin('tbl_settings_company_settings', 'tbl_settings_company_settings.id', '=', 'tbl_setups_sisterconcern_categories.sister_concern_id')
                ->select('tbl_settings_company_settings.name')
                ->where('tbl_setups_sisterconcern_categories.deleted', 'No')
                ->where('tbl_setups_sisterconcern_categories.status', 'Active')
                ->where('tbl_settings_company_settings.deleted', 'No')
                ->where('tbl_settings_company_settings.status', 'Active')
                ->where('tbl_setups_sisterconcern_categories.category_id', $category->id)
                ->get();
    
            // Prepare sister concern names
            $sisterConcernsName = '';
            $a = 1;
            foreach ($sisterConcerns as $sisterConcern) {
                $sisterConcernsName .= '<b>' . $a++ . '.</b> ' . $sisterConcern->name . '<br>';
            }
    
            // Status column
            $status = $category->status == 'Active'
                ? '<center><i class="fas fa-check-circle" style="color:green; font-size:16px;" title="' . $category->status . '"></i></center>'
                : '<center><i class="fas fa-times-circle" style="color:red; font-size:16px;" title="' . $category->status . '"></i></center>';
    
            // Image URL handling
            $imagePath = 'upload/category_images/' . $category->image;
            $imageUrl = file_exists(public_path($imagePath)) && $category->image != '' ? url($imagePath) : url('upload/no_image.png');
    
            // Action buttons
            $button = '<td style="width: 12%;">
                        <div class="btn-group">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
                                <i class="fas fa-cog"></i>  <span class="caret"></span></button>
                                <ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu">
                                <li class="action" onclick="editCategory(' . $category->id . ')"  ><a  class="btn" ><i class="fas fa-edit"></i> Edit </a></li>
                                <li class="action"><a   class="btn"  onclick="confirmDelete(' . $category->id . ')" ><i class="fas fa-trash-alt"></i> Delete </a></li>
                                </ul>
                            </div>
                        </td>';
    
            // Prepare the data row for each category
            $output['data'][] = array(
                $i++ . '<input type="hidden" name="id" id="id" value="' . $category->id . '" />',
                $category->name,
                $category->category_type,
                $sisterConcernsName,
                '<img style="width:70px;" src="' . $imageUrl . '" alt="' . $category->name . '" />',
                $category->sort_code,
                $status,
                $button
            );
        }
    
        return $output;
    }
    



















    public function add()
    {
        return Category::all();
    }

    public function store(Request $request)
    {    
     
       
        $request->validate([
            'name' => 'required|max:255|unique:tbl_setups_categories,name|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'sort_code' => 'numeric|required',
            'category_type'=> 'required'
        ]);
        
        if ($request->hasFile('image')) {
            $request->validate([
                'image'   =>  'image|max:2048'
            ]);
            $categoryImage = $request->file('image');
            $name = $categoryImage->getClientOriginalName();
            $uploadPath = 'upload/category_images/';
            $imageUrl = $uploadPath . $name;
            $imageName = time() . $name;
            $categoryImage->move($uploadPath, $imageName);
        } else {
            $imageName = "no_image.png";
        }
        
        $category = new Category();
        $category->name = $request->name;
        $category->sort_code = $request->sort_code;
        $category->category_type = $request->category_type;
        $category->image = $imageName;
        $category->created_by = auth()->user()->id;
        $category->created_date = date('Y-m-d H:i:s');
        $category->deleted = 'No';
        $category->save(); 

        $sisterConcernIds=explode(",",$request->sisterConcern_id);
            $i=0;
            foreach($sisterConcernIds as $sisterConcernId){
                $sisterConcernWarehouse= new SisterConcernCategory();
                 $sisterConcernWarehouse->sister_concern_id=$sisterConcernId[$i];
                // $sisterConcernWarehouse->sister_concern_id = $sisterConcernId;
                //  $sisterConcernWarehouse->sort_code=$request->sort_code;
                $sisterConcernWarehouse->category_id=$category->id;
                $sisterConcernWarehouse->status='Active';
                $sisterConcernWarehouse->deleted='No';
                $sisterConcernWarehouse->created_by=auth()->user()->id;
                $sisterConcernWarehouse->save();
            }
        
        return response()->json(['success' => 'Category saved successfully']);
    }

    public function edit(Request $request)
    {
        $category = Category::find($request->id);
        $data='';
        $sisterConcerns=SisterConcernCategory::
                leftjoin('tbl_settings_company_settings','tbl_settings_company_settings.id','=','tbl_setups_sisterconcern_categories.sister_concern_id')
                ->select('tbl_setups_sisterconcern_categories.*','tbl_settings_company_settings.name','tbl_settings_company_settings.deleted','tbl_settings_company_settings.status')
                ->where('tbl_setups_sisterconcern_categories.deleted','=','No')
                ->where('tbl_setups_sisterconcern_categories.status','=','Active')
                ->where('tbl_settings_company_settings.deleted','=','No')
                ->where('tbl_settings_company_settings.status','=','Active')
                ->where('tbl_setups_sisterconcern_categories.category_id','=',$request->id)
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
            $sisterConcern=SisterConcernCategory::where('tbl_setups_sisterconcern_categories.deleted','=','No')
                ->where('tbl_setups_sisterconcern_categories.status','=','Active')
                ->where('tbl_setups_sisterconcern_categories.category_id','=',$request->id)
                ->first();
            $data=array(
                'category'=>$category,
                'sisterConcern'=>$sisterConcern,
                'sisterConcernsName'=>$sisterConcernsName
            );
        return $data;
        
    }

    public function update(Request $request)
    {
        // return  $request;
        // $request->validate([
        //     'name' => 'required|max:255||regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u'.$request->id,
        //     'category_type'=> 'required'
        // ]);
        DB::beginTransaction();
		try {
        $category = Category::find($request->id);
        $category->name = $request->name;
      
        if ($request->removeImage == "1") {
            $category->image = "no_image.png";
        } else if ($request->hasFile('image')) {
            $request->validate([
                'image'   =>  'image|max:2048'
            ]);
            $categoryImage = $request->file('image');
            $name = $categoryImage->getClientOriginalName();
            $uploadPath = 'upload/category_images/';
            $imageUrl = $uploadPath . $name;
            $imageName = time() . $name;
            $categoryImage->move($uploadPath, $imageName);
            $category->image = $imageName;
        }

        $category->category_type = $request->category_type;
        $category->status = $request->Status;
        $category->updated_by = auth()->user()->id;
        $category->updated_date = date('Y-m-d H:i:s');
        $category->save();

        $deleteSisterConcerncategories=SisterConcernCategory::where('category_id','=',$request->id)
                                    ->where('status','=','Active')
                                    ->where('deleted','=','No')
                                    ->get();
        foreach($deleteSisterConcerncategories as $val){
            $sisterConcernCategory= SisterConcernCategory::find($val->id);
            $sisterConcernCategory->status='Inactive';
            $sisterConcernCategory->deleted='Yes';
            $sisterConcernCategory->deleted_by=auth()->user()->id;
            $sisterConcernCategory->deleted_date=date('Y-m-d H:i:s');
            $sisterConcernCategory->save();
        }

        $sisterConcernIds=explode(",",$request->sisterConcern_id);
        $i=0;
        foreach($sisterConcernIds as $sisterConcernId){
                $sisterConcernCategory= new SisterConcernCategory();
                $sisterConcernCategory->sister_concern_id=$sisterConcernId[$i];
                $sisterConcernCategory->category_id=$request->id;
                $sisterConcernCategory->sort_code=$request->sort_code;
                $sisterConcernCategory->status='Active';
                $sisterConcernCategory->deleted='No';
                $sisterConcernCategory->created_by=auth()->user()->id;
                $sisterConcernCategory->save();
            
        }
    
            DB::commit();
            return response()->json(['success' => 'Category updated successfully']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Warehouse rollBack!']);
        }
        
    }

    public function delete(Request $request)
    {
        $category = Category::find($request->id);
        $category->deleted = 'Yes';
        $category->name = $category->name . '-Deleted-' . $request->id;
        $category->deleted_by = auth()->user()->id;
        $category->deleted_date = date('Y-m-d H:i:s');
        $category->save();
        $deleteSisterConcerncategories=SisterConcernCategory::where('category_id','=',$request->id)
                                    ->where('status','=','Active')
                                    ->where('deleted','=','No')
                                    ->get();
        foreach($deleteSisterConcerncategories as $val){
            $sisterConcernCategory= SisterConcernCategory::find($val->id);
            $sisterConcernCategory->status='Inactive';
            $sisterConcernCategory->deleted='Yes';
            $sisterConcernCategory->deleted_by=auth()->user()->id;
            $sisterConcernCategory->deleted_date=date('Y-m-d H:i:s');
            $sisterConcernCategory->save();
        }
        return response()->json(['success' => 'Category deleted successfully']);
    }


    

    // Start Warehouse Transfer
    public function warehouseTransferView()
    {
        $data['warehouses'] = Warehouse::where('deleted', 'No')->where('status', 'Active')->get();
        $data['products'] = Product::where('deleted', 'No')->where('status', 'Active')->where('current_stock', '>', 0)->get();
        return view('admin.inventory.warehouse.warehouseTransfer', $data);
    }
    public function productwiseWarehouse(Request $request)
    {
        $product_id = $request->product_id;
        $warehouses = DB::table('tbl_currentstock')
            ->join('tbl_warehouse', 'tbl_currentstock.tbl_wareHouseId', '=', 'tbl_warehouse.id')
            ->where('tbl_currentstock.tbl_productsId', $product_id)
            ->select('tbl_warehouse.id', 'tbl_warehouse.wareHouseName')
            ->get();
        $warehouse_data = '';
        foreach ($warehouses as $warehouse) {
            $warehouse_data .= '<option value="' . $warehouse->id . '">' . $warehouse->wareHouseName . '</option>';
        }
        return $warehouse_data;
    }
    public function warehousewiseProductStock(Request $request)
    {
        $warehouse_id = $request->warehouse_id;
        $product_id = $request->product_id;
        $currentStock = Currentstock::where('tbl_productsId', $product_id)->where('tbl_wareHouseId', $warehouse_id)->where('deleted', 'No')->first();
        if ($currentStock != null) {
            return $currentStock->currentStock;
        } else {
            return 0;
        }
    }
    public function warehouseTransferStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $WarehouseTransfer = new WarehouseTransfer();
            $WarehouseTransfer->transferDate = $request->transferDate;
            $WarehouseTransfer->tbl_current_warehouse_id = $request->warehouseFrom;
            $WarehouseTransfer->tbl_products_id = $request->product;
            $WarehouseTransfer->current_stock = $request->currentStock;
            $WarehouseTransfer->tbl_transfer_warehouse_id = $request->warehouseTo;
            $WarehouseTransfer->transfer_stock = $request->transferStock;
            $WarehouseTransfer->entryBy = auth()->user()->id;
            $WarehouseTransfer->entryDate = date('Y-m-d H:i:s');
            $WarehouseTransfer->save();

            $product_id = $request->product;
            $quantity = $request->transferStock;
            $warehouse_id = $request->warehouseTo;
            $Currentstock = Currentstock::where("tbl_productsId", $product_id)
                ->where("tbl_wareHouseId", $warehouse_id)
                ->where("deleted", 'No');
            if ($Currentstock->first()) {
                $Currentstock->increment('currentStock', $quantity);
                $Currentstock->increment('transferTo', $quantity);
            } else {
                $Currentstock_insert = new Currentstock();
                $Currentstock_insert->tbl_productsId = $product_id;
                $Currentstock_insert->tbl_wareHouseId = $warehouse_id;
                $Currentstock_insert->currentStock = $quantity;
                $Currentstock_insert->transferTo = $quantity;
                $Currentstock_insert->entryBy = auth()->user()->id;
                $Currentstock_insert->entryDate = date('Y-m-d H:i:s');
                $Currentstock_insert->save();
            }

            $warehouse_id = $request->warehouseFrom;
            $Currentstock = Currentstock::where("tbl_productsId", $product_id)
                ->where("tbl_wareHouseId", $warehouse_id)
                ->where("deleted", 'No');
            if ($Currentstock->first()) {
                $Currentstock->decrement('currentStock', $quantity);
                $Currentstock->increment('transferFrom', $quantity);
            } else {
                $Currentstock_insert = new Currentstock();
                $Currentstock_insert->tbl_productsId = $product_id;
                $Currentstock_insert->tbl_wareHouseId = $warehouse_id;
                $Currentstock_insert->currentStock = -$quantity;
                $Currentstock_insert->transferFrom = $quantity;
                $Currentstock_insert->entryBy = auth()->user()->id;
                $Currentstock_insert->entryDate = date('Y-m-d H:i:s');
                $Currentstock_insert->save();
            }

            DB::commit();
            return response()->json(['success' => 'Warehouse Transfer successfully']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Warehouse Transfer rollBack ' . $e]);
        }
    }

    public function viewWarehousesTransfer()
    {
        $data = "";
        $warehouseTransfers = DB::table('tbl_warehouse_transfer')
            ->join('tbl_warehouse', 'tbl_warehouse_transfer.tbl_current_warehouse_id', 'tbl_warehouse.id')
            ->join('tbl_warehouse as warehouse', 'tbl_warehouse_transfer.tbl_transfer_warehouse_id', 'warehouse.id')
            ->join('products', 'tbl_warehouse_transfer.tbl_products_id', 'products.id')
            ->where('tbl_warehouse_transfer.deleted', 'No')
            ->select('tbl_warehouse_transfer.id', 'tbl_warehouse_transfer.transfer_stock', 'warehouse.wareHouseName as warehouse_to', 'tbl_warehouse.wareHouseName as warehouse_from', 'products.name', 'tbl_warehouse_transfer.transferDate')
            ->get();
        //dd($warehouseTransfers);
        $output = array('data' => array());
        $i = 1;
        foreach ($warehouseTransfers as $warehouseTransfer) {
            $button = '<a   class="btn"  onclick="confirmDelete(' . $warehouseTransfer->id . ')" ><i class="fas fa-trash-alt"></i> </a>';
            $output['data'][] = array(
                $i++ . '<input type="hidden" name="id" id="id" value="' . $warehouseTransfer->id . '" />',
                'ProductName: ' . $warehouseTransfer->name . '<br>Date: ' . $warehouseTransfer->transferDate,
                $warehouseTransfer->warehouse_from,
                $warehouseTransfer->warehouse_to,
                $warehouseTransfer->transfer_stock,
                $button
            );
        }

        return $output;
    }

    public function deleteWarehouseTransfer(Request $request)
    {
        $id = $request->id;
        $WarehouseTransfer = WarehouseTransfer::find($id);
        $WarehouseTransfer->deleted = 'Yes';
        $WarehouseTransfer->deletedBy = auth()->user()->id;
        $WarehouseTransfer->deletedDate = date('Y-m-d H:i:s');
        $WarehouseTransfer->save();

        $warehouseFrom = $WarehouseTransfer->tbl_current_warehouse_id;
        $warehouseTo = $WarehouseTransfer->tbl_transfer_warehouse_id;


        $product_id = $WarehouseTransfer->tbl_products_id;
        $quantity = $WarehouseTransfer->transfer_stock;
        $warehouse_id = $warehouseTo;
        $Currentstock = Currentstock::where("tbl_productsId", $product_id)
            ->where("tbl_wareHouseId", $warehouse_id)
            ->where("deleted", 'No');
        if ($Currentstock->first()) {
            $Currentstock->decrement('currentStock', $quantity);
            $Currentstock->increment('transferToDelete', $quantity);
        } else {
            $Currentstock_insert = new Currentstock();
            $Currentstock_insert->tbl_productsId = $product_id;
            $Currentstock_insert->tbl_wareHouseId = $warehouse_id;
            $Currentstock_insert->currentStock = -$quantity;
            $Currentstock_insert->transferToDelete = $quantity;
            $Currentstock_insert->entryBy = auth()->user()->id;
            $Currentstock_insert->entryDate = date('Y-m-d H:i:s');
            $Currentstock_insert->save();
        }


        $warehouse_id = $warehouseFrom;
        $Currentstock = Currentstock::where("tbl_productsId", $product_id)
            ->where("tbl_wareHouseId", $warehouse_id)
            ->where("deleted", 'No');
        if ($Currentstock->first()) {
            $Currentstock->increment('currentStock', $quantity);
            $Currentstock->increment('transferFromDelete', $quantity);
        } else {
            $Currentstock_insert = new Currentstock();
            $Currentstock_insert->tbl_productsId = $product_id;
            $Currentstock_insert->tbl_wareHouseId = $warehouse_id;
            $Currentstock_insert->currentStock = $quantity;
            $Currentstock_insert->transferFromDelete = $quantity;
            $Currentstock_insert->entryBy = auth()->user()->id;
            $Currentstock_insert->entryDate = date('Y-m-d H:i:s');
            $Currentstock_insert->save();
        }
    }
    // End Warehouse Transfer

}
