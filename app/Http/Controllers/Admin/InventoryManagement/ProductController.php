<?php

namespace App\Http\Controllers\Admin\InventoryManagement;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\setups\Category;
use App\Models\inventory\Product;
use App\Models\Setups\Brand;
use App\Models\Setups\Currentstock;
use App\Models\Setups\Unit;
use App\Models\inventory\DamageProduct;
use App\Models\inventory\Productspecification;
use App\Models\inventory\SerializeProduct;
use App\Models\setups\Warehouse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use PDF;
use Carbon\Carbon;
use Image;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    /*  function __construct()
    {
        $this->middleware('permission:products.view', ['only' => ['index', 'getProducts']]);
        $this->middleware('permission:products.store', ['only' => ['store']]);
        $this->middleware('permission:products.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:products.delete', ['only' => ['delete']]);
        // Damage
        $this->middleware('permission:damage.view', ['only' => ['damageIndex', 'getDamage']]);
        $this->middleware('permission:damage.store', ['only' => ['damageStore']]);
        $this->middleware('permission:damage.delete', ['only' => ['damageDelete']]);
    }  */

    public function index()
    {
        
        $data['categories'] = Category::where('deleted', 'No')->where('status','=','Active')->where('name','!=','Service')->get();
        $data['brands'] = Brand::where('deleted', 'No')->where('status','=','Active')->where('name','!=','Service')->get();
        $data['units'] = Unit::where('deleted', 'No')->where('status','=','Active')->get();
        $data['warehouses'] = Warehouse::where('deleted', 'No')->where('status','=','Active')->get();
        $data['sisterconcern'] = DB::table('tbl_settings_company_settings')->where('deleted', 'No')->where('status', 'Active') ->get();
        $data['logged_sister_concern_id'] = Session::get('companySettings')[0]['id'];
        return view('admin.inventoryManagement.products.view-products', $data);
    }

    public function slug_generate(Request $request)
    {
     
        $product = $request->productName;
        $categories = Category::find($request->categoryName);
        $brands = Brand::find($request->brandName);
       $slugSource = $brands->name . ' ' . $categories->name . ' ' . $product;
    
   
    $slug = Str::slug($slugSource, '-');
    
  
    return $slug;
 
    }
    public function edit_slug_generate(Request $request)
    {
     
        $product = $request->productName;
        $categories = Category::find($request->categoryName);
        $brands = Brand::find($request->brandName);
       $slugSource = $brands->name . ' ' . $categories->name . ' ' . $product;
    
   
    $slug = Str::slug($slugSource, '-');
    
  
    return $slug;
 
    }

    public function sisterconcernwisewarehouse(Request $request){
        // return $request;
        $warehouse_id = DB::table('tbl_setups_sister_concern_to_warehouses')
        ->leftJoin('tbl_setups_warehouses', 'tbl_setups_sister_concern_to_warehouses.warehouse_id', '=', 'tbl_setups_warehouses.id')
        ->select('tbl_setups_sister_concern_to_warehouses.warehouse_id', 'tbl_setups_warehouses.name')
        ->where('tbl_setups_sister_concern_to_warehouses.sister_concern_id', $request->sisterconcern_id)
        ->where('tbl_setups_warehouses.deleted', 'No')
        ->where('tbl_setups_sister_concern_to_warehouses.warehouse_id','!=', '0')
        ->get();
   
        return $warehouse_id;
    }
    public function sisterconcernwisewarehouseedit(Request $request){
        // return $request;
        $warehouse_id = DB::table('tbl_setups_sister_concern_to_warehouses')
        ->leftJoin('tbl_setups_warehouses', 'tbl_setups_sister_concern_to_warehouses.warehouse_id', '=', 'tbl_setups_warehouses.id')
        ->select('tbl_setups_sister_concern_to_warehouses.warehouse_id', 'tbl_setups_warehouses.name')
        ->where('tbl_setups_sister_concern_to_warehouses.sister_concern_id', $request->editsisterconcern_id)
        ->where('tbl_setups_warehouses.deleted', 'No')
        ->where('tbl_setups_sister_concern_to_warehouses.warehouse_id','!=', '0')
        ->get();
   
        return $warehouse_id;
    }



    public function getProducts()
    {
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $products = DB::table('tbl_inventory_products')
            ->leftjoin('tbl_setups_brands', 'tbl_inventory_products.brand_id', '=', 'tbl_setups_brands.id')
            ->leftjoin('tbl_setups_units', 'tbl_inventory_products.unit_id', '=', 'tbl_setups_units.id')
            ->leftjoin('tbl_setups_categories', 'tbl_inventory_products.category_id', '=', 'tbl_setups_categories.id')
            ->select('tbl_inventory_products.id', 'tbl_inventory_products.status', 'tbl_inventory_products.type', 'tbl_inventory_products.image', 'tbl_inventory_products.name', 'tbl_inventory_products.model_no', 'tbl_inventory_products.code', 'tbl_inventory_products.barcode_no', 'tbl_inventory_products.opening_stock', 'tbl_inventory_products.current_stock', 'tbl_inventory_products.remainder_quantity', 'tbl_inventory_products.purchase_price', 'tbl_inventory_products.sale_price', 'tbl_inventory_products.discount', 'tbl_setups_categories.name as categoryName', 'tbl_setups_brands.name as brandName', 'tbl_setups_units.name as unitName')
            ->where('tbl_inventory_products.deleted', 'No')
            ->where('tbl_inventory_products.status', 'Active')
            ->where('tbl_setups_brands.deleted', 'No')
            ->where('tbl_setups_brands.status', 'Active')
            ->where('tbl_setups_categories.deleted', 'No')
            ->where('tbl_setups_categories.status', 'Active')
            ->where('tbl_inventory_products.sister_concern_id','=',$logged_sister_concern_id)
            ->orderBy('tbl_inventory_products.id', 'DESC')
            ->get();

        $output = array('data' => array());
        $i = 1;
        foreach ($products as $product) {
            $status = "";
            if ($product->status == 'Active') {
                $status = '<center><i class="fas fa-check-circle" style="color:green; font-size:16px;"></i></center>';
            } else {
                $status = '<center><i class="fas fa-times-circle" style="color:red; font-size:16px;"></i></center>';
            }
            $imageUrl = url('upload/product_images/thumbs/' . $product->image);
            if($product->type == 'service'){
                $button = '<td style="width: 12%;">
                <div class="btn-group">
                    <button type="button" class="btn btn-cyan dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-cog"></i>  <span class="caret"></span></button>
                        <ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu">
                        <li class="action liDropDown" onclick="editProduct(' . $product->id . ')"  ><a  class="btn" ><i class="fas fa-edit"></i> Edit </a></li></li>
                        <li class="action liDropDown"><a   class="btn"  onclick="confirmDelete(' . $product->id . ')" ><i class="fas fa-trash-alt"></i> Delete </a></li>
                        </li> 
                        </ul>
                    </div>
                </td>';
            }else{
                $button = '<td style="width: 12%;">
                <div class="btn-group">
                    <button type="button" class="btn btn-cyan dropdown-toggle" data-toggle="dropdown">
                        <i class="fas fa-cog"></i>  <span class="caret"></span></button>
                        <ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu">
                        <li class="action liDropDown" onclick="editProduct(' . $product->id . ')"  ><a  class="btn" ><i class="fas fa-edit"></i> Edit </a></li></li>
                        <li class="action liDropDown" onclick="editOpenStock(' . $product->id . ')"  ><a  class="btn" ><i class="fas fa-edit"></i> Update Opening Stock</a></li></li>
                    </li>
                        <li class="action liDropDown"><a   class="btn"  onclick="confirmDelete(' . $product->id . ')" ><i class="fas fa-trash-alt"></i> Delete </a></li>
                        </li> 
                        </ul>
                    </div>
                </td>';
            }
           

            $output['data'][] = array(
                $i++ . '<input type="hidden" name="id" id="id" value="' . $product->id . '" />',
                '<b>Name: </b>'.$product->name . '<br><b>Code: </b>' . $product->code,
                '<b>Category: </b>' . $product->categoryName . ' <br><b>Brand: </b>' . $product->brandName . '<br><b>Unit: </b>' . $product->unitName . '<br><b>Type: </b>' . Str::ucfirst($product->type),
                '<center><img style="max-width:50px; max-height:80px;" src="' . $imageUrl . '" alt="no image" /></center>',
                '<b>OS: </b>' . $product->opening_stock . '<br><b>RQ: </b>' . $product->remainder_quantity . '<br><b>Available: </b>' . $product->current_stock,
                '<b>CP: </b>' . Session::get('companySettings')[0]['currency'] . ' ' . $product->purchase_price . '<br><b>PP: </b>' . Session::get('companySettings')[0]['currency'] . ' ' . $product->sale_price,
                $status,
                $button
            );
        }
        return $output;
    }



 


    public function getAdvanceSearchProducts(Request $request)
    {
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $products = DB::table('tbl_inventory_products')
            ->leftjoin('tbl_setups_brands', 'tbl_inventory_products.brand_id', '=', 'tbl_setups_brands.id')
            ->leftjoin('tbl_setups_units', 'tbl_inventory_products.unit_id', '=', 'tbl_setups_units.id')
            ->leftjoin('tbl_setups_categories', 'tbl_inventory_products.category_id', '=', 'tbl_setups_categories.id')
            ->select('tbl_inventory_products.id', 'tbl_inventory_products.status', 'tbl_inventory_products.image', 'tbl_inventory_products.name', 'tbl_inventory_products.code', 'tbl_inventory_products.barcode_no', 'tbl_inventory_products.opening_stock', 'tbl_inventory_products.current_stock', 'tbl_inventory_products.remainder_quantity', 'tbl_inventory_products.purchase_price', 'tbl_inventory_products.sale_price', 'tbl_inventory_products.discount', 'tbl_setups_categories.name as categoryName', 'tbl_setups_brands.name as brandName', 'tbl_setups_units.name as unitName')
            ->where('tbl_inventory_products.deleted', 'No')
            ->where('tbl_inventory_products.status', 'Active')
            ->where('tbl_setups_brands.deleted', 'No')
            ->where('tbl_setups_brands.status', 'Active')
            ->where('tbl_setups_categories.deleted', 'No')
            ->where('tbl_setups_categories.status', 'Active')
            ->where('tbl_inventory_products.sister_concern_id','=',$logged_sister_concern_id)
            ->orderBy('tbl_inventory_products.id', 'DESC')
            ->get();
        $output = array('data' => array());
        $i = 1;
        foreach ($products as $product) {
            $productId = $product->id;
            $specs = DB::table('tbl_inventory_product_specification')->where('deleted', 'No')->where('tbl_product_id', $productId)->get();
            $productSpecs = '';
            foreach ($specs as $spec) {
                $productSpecs .= '<tr><td><b>' . $spec->specificationName . ' : </b></td><td>' . $spec->specificationValue . '</td></tr><br>';
            }
            if ($request->page == "Purchase") {
                $button = '<td>
                            <div >
                                <button type="button" class="btn btn-cyan" onclick="warehouseWiseStock(' . $product->id . ');"> <i class="fa fa-eye"> </i> </button>
                                <button type="button" class="btn btn-cyan" onclick="selectProductWOWarehouse(' . $product->id . ');"> <i class="fa fa-plus"> </i> </button>
                            </div>
                            </td>';
            } else {
                $button = '<td>
                            <div >
                                <button type="button" class="btn btn-cyan" onclick="warehouseWiseStock(' . $product->id . ');"> <i class="fa fa-eye"> </i> </button>
                            </div>
                            </td>';
            }

            $output['data'][] = array(
                $i++ . '<input type="hidden" name="id" id="id" value="' . $product->id . '" />',
                $product->name . ' <br><b>Code: </b>' . $product->code . '<br><b>Barcode: </b>' . $product->barcode_no,
                '<b>Category: </b>' . $product->categoryName . ' <br><b>Brand: </b>' . $product->brandName . '<br><b>Unit: </b>' . $product->unitName,
                $productSpecs,
                '<b>PP: </b>' . Session::get('companySettings')[0]['currency'] . ' ' . $product->purchase_price . '<br><b>SP: </b>' . Session::get('companySettings')[0]['currency'] . ' ' . $product->sale_price . '<br><b>Dis: </b>' . Session::get('companySettings')[0]['currency'] . ' ' . $product->discount,
                '<h6 class="text-cyan">Stock : ' . $product->current_stock . '</h6><div id="' . $product->id . '"></div>',
                $button
            );
        }
        return $output;
    }


    
    public function warehouseWiseStock(Request $request)
    {
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $productId = $request->id;
        $currentstocks = DB::table('tbl_currentstock')
            ->join('tbl_setups_warehouses', 'tbl_currentstock.tbl_wareHouseId', '=', 'tbl_setups_warehouses.id')
            ->select('tbl_currentstock.id', 'tbl_currentstock.tbl_wareHouseId', 'tbl_currentstock.tbl_wareHouseId', 'tbl_currentstock.currentStock', 'tbl_setups_warehouses.name')
            ->where('tbl_currentstock.tbl_productsId', $productId)
            ->where('tbl_currentstock.sister_concern_id', $logged_sister_concern_id)
            ->where('tbl_currentstock.deleted', 'No')
            ->where('tbl_setups_warehouses.deleted', 'No')
            ->orderBy('tbl_currentstock.id','ASC')
            ->distinct('tbl_setups_warehouses.id')
            ->get();

        $warehouseWiseStock = '';
        foreach ($currentstocks as $stock) {
            $warehouseWiseStock .= '<table style="border: 1px solid #ececec;"><tr id="warehouseWise"><td><b id="wrhs_name' . $stock->tbl_wareHouseId . '">' . $stock->name . '</b>:</td><td width="25%" >' . $stock->currentStock . '</td><td width="5%"><a href="#" class="btn btn-sm btn-success rounded" onclick="selectProducts(' . $productId . ',' . $stock->tbl_wareHouseId . ')"><i class="fa fa-plus"></i></a></td></tr></table>';
        }
        return  $warehouseWiseStock;
    }

    public function brandAndCategoryWise(Request $request)
    {
        $categoryId = $request->categoryId;
        $brandId = $request->brandId;
        $warehouseId = $request->warehouseId;
        // Added By Hamid (line: 150 to 161)
        if ($categoryId != "" && $brandId != "" && $warehouseId != "") {
            // WarehouseWise Product(s)
            $product = DB::table('tbl_inventory_products')
                ->join('tbl_currentstock', 'tbl_inventory_products.id', '=', 'tbl_currentstock.tbl_productsId')
                ->select('tbl_inventory_products.*', 'tbl_currentstock.currentStock')
                ->where('tbl_inventory_products.deleted', 'No')
                ->where('tbl_inventory_products.category_id', $categoryId)
                ->where('tbl_inventory_products.brand_id', $brandId)
                ->where('tbl_currentstock.tbl_wareHouseId', $warehouseId)
                ->where('tbl_inventory_products.deleted', 'No')
                ->get();
            // End Added By Hamid
        } else if ($categoryId == "" && $brandId == "") {
            if ($request->type == 'purchase') {
                $product = Product::where('deleted', 'No')
                    ->where('status', 'Active')
                    ->get();
            } else {
                $product = Product::where('deleted', 'No')
                    ->where('current_stock', '>', 0)
                    ->where('status', 'Active')
                    ->get();
            }
        } else if ($categoryId == "") {
            if ($request->type == 'purchase') {
                $product = DB::table('tbl_inventory_products')
                    ->where('deleted', 'No')
                    ->where('brand_id', $brandId)
                    ->where('status', 'Active')
                    ->get();
            } else {
                $product = DB::table('tbl_inventory_products')
                    ->where('deleted', 'No')
                    ->where('brand_id', $brandId)
                    ->where('status', 'Active')
                    ->where('current_stock', '>', 0)
                    ->get();
            }
        } else if ($brandId == "") {
            if ($request->type == 'purchase') {
                $product = DB::table('tbl_inventory_products')
                    ->where('deleted', 'No')
                    ->where('category_id', $categoryId)
                    ->where('status', 'Active')
                    ->get();
            } else {
                $product = DB::table('tbl_inventory_products')
                    ->where('deleted', 'No')
                    ->where('category_id', $categoryId)
                    ->where('status', 'Active')
                    ->where('current_stock', '>', 0)
                    ->get();
            }
        } else {
            if ($request->type == 'purchase') {
                $product = DB::table('tbl_inventory_products')
                    ->where('deleted', 'No')
                    ->where('category_id', $categoryId)
                    ->where('brand_id', $brandId)
                    ->where('status', 'Active')
                    ->get();
            } else {
                $product = DB::table('tbl_inventory_products')
                    ->where('deleted', 'No')
                    ->where('category_id', $categoryId)
                    ->where('brand_id', $brandId)
                    ->where('status', 'Active')
                    ->where('current_stock', '>', 0)
                    ->get();
            }
        }
        return $product;
    }
 



    
    public function store(Request $request)
    {
        $discount = $request->discount;
        $logged_sister_concern_id = Session::get('companySettings')[0]['id'];
        $request->validate([
            'name' => 'required|unique:tbl_inventory_products,name|max:255|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'opening_stock' => 'required|max:7|regex:/^\d+(\.\d{1,2})?$/',
            'remainder_quantity' => 'required|max:7|regex:/^\d+(\.\d{1,2})?$/',
            'category_id' => 'required',
            'sisterconcern' => 'required',
            'brand_id' => 'required',
             'stock_warehouse' => 'required|max:7|regex:/^\d+(\.\d{1,2})?$/',
            'unit_id' => 'required',
            'purchase_price' => 'required|max:7|regex:/^\d+(\.\d{1,2})?$/',
            'sale_price' => 'required|max:7|regex:/^\d+(\.\d{1,2})?$/',
            'discount' => 'numeric|nullable',
             'type' => 'required',
            'stockCheck' => 'required',
            'specNames'=>'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'specValues'=>'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'notes'=> 'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u'
        ]);
        
        //--- If Dicount In Percentage(%)---//
        //         if ($lastChar == "%") {
        //             $discount =  $discountInNumbmer;
        //             $salePrice =   $request->sale_price;
        //             $amount = ($salePrice / 100);
        //             $discountAmount = $amount * $discount;
        //             $request['discount'] = $discountAmount;
        //         }
        // return $request->discount;

        if ($request->type == "serialize") {
            $request->validate([
                'itemsInBox' => 'required',
                'serialNumbers' => 'required',
                'stockQuantities' => 'required'
            ]);
        }
        if ($request->hasFile('image')) {
            $request->validate([
                'image'   =>  'image|max:2048'
            ]);

            $productImage = $request->file('image');
            $name = $productImage->getClientOriginalName();
            $uploadPath = 'upload/product_images/thumbs/';
            $uploadResizePath = 'upload/product_images/resizes/';
            $uploadPathOriginal = 'upload/product_images/';
            $imageName = time() . $name;
            $imageUrl = $uploadPath . $imageName;
            $resizeUrl = $uploadResizePath . $imageName;
            //--resize image upload in public--//
            Image::make($productImage)->resize(360, 360)->save($resizeUrl);
            Image::make($productImage)->resize(100, 100)->save($imageUrl);
            //--original image upload in public--//
            $request->image->move(public_path($uploadPathOriginal), $imageName);
            // End Image Resize
        } else {
            $imageName = "no_image.png";
        }
        
        DB::beginTransaction();
        try {
            $productCode = Product::where('deleted','=','No')->where('status','=','Active')->max('code');
            $productCode++;
            $productCode = str_pad($productCode, 6, '0', STR_PAD_LEFT);

            $product = new Product();
            $product->name = $request->name;
            $product->image = $imageName;
            $product->code = $productCode;

            if($request->barcode_no == ''){
                $barcode_no = $productCode;
            }else{
                $barcode_no = '';
            }

            $product->barcode_no = $barcode_no;
            $product->category_id = $request->category_id;
            $product->sister_concern_id = $request->sisterconcern_id;
            $product->tbl_warehouseid = $request->stock_warehouse;
            $product->slug = $request->slug;
            $product->brand_id = $request->brand_id;
            $product->unit_id = $request->unit_id;
            $product->opening_stock = $request->opening_stock;
            $product->current_stock = $request->opening_stock;
            $product->remainder_quantity = $request->remainder_quantity;
            $product->purchase_price = $request->purchase_price;
            $product->sale_price = $request->sale_price;
            $product->discount = $discount;
            $product->notes = $request->notes;
            $product->model_no = $request->model_no;
            $product->created_by = auth()->user()->id;
            $product->created_date = date('Y-m-d H:i:s');
            $product->type = $request->type;
            $product->stock_check = $request->stockCheck;
            $product->items_in_box = $request->itemsInBox;
            $product->save();
            $productId = $product->id;
            // Serialize Product
            if ($request->type == "serialize") {
                
                $serialNumbers = explode(",", $request->serialNumbers);
                $stockQuantities = explode(",", $request->stockQuantities);
                $k = 0;
                foreach ($serialNumbers as $serialNumber) {
                    $serialize = new SerializeProduct();
                    $serialize->tbl_productsId = $productId;
                    $serialize->serial_no = $serialNumber;
                    $serialize->quantity = $stockQuantities[$k];
                    $serialize->warehouse_id = $request->stock_warehouse;
                    $serialize->created_by = auth()->user()->id;
                    $serialize->created_date = date('Y-m-d H:i:s');
                    $serialize->save();
                    $k++;
                }
            }
            $specNames = explode(",", $request->specNames);
            $specValues = explode(",", $request->specValues);
            if ($specNames[0] != -1 || $specValues[0] != -1) {
                
                $i = 0;
                foreach ($specNames as  $specName) {
                    $spec = new Productspecification();
                    $spec->tbl_product_id  = $productId;
                    $spec->specification_name = $specName;
                    $spec->specification_Value = $specValues[$i];
                    $spec->created_by = auth()->user()->id;
                    $spec->created_date = date('Y-m-d H:i:s');
                    $spec->save();
                    $i++;
                }
            }
            // Currentstock
            if ($request->type == "service") {
                DB::commit();
                return response()->json(['success' => 'Product saved successfully']);
            }
            $currentStock = new Currentstock();
            $currentStock->tbl_productsId  = $productId;
            $currentStock->tbl_wareHouseId = $request->stock_warehouse;
            $currentStock->currentStock = $request->opening_stock;
            $currentStock->initialStock = $request->opening_stock;
            $currentStock->purchaseStock = 0;
            $currentStock->break_Quantity = 0;
            $currentStock->broken_quantity = 0;
            $currentStock->broken_sold = 0;
            $currentStock->broken_damage = 0;
            $currentStock->broken_remaining = 0;
            $currentStock->broken_perslice_price = 0;
            $currentStock->entryBy = auth()->user()->id;
            $currentStock->entryDate = date('Y-m-d H:i:s');
            $currentStock->save();
           
            DB::commit();
            return response()->json(['success' => 'Product saved successfully']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => "rollBack! Please try again"]);
        }
    }





    





    public function servicestore(Request $request)
    {
        // return $request->specNames;
        $request->validate([
            'name' => 'required|max:255|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'purchase_price' => 'max:7|regex:/^\d+(\.\d{1,2})?$/',
            'sale_price' => 'max:7|regex:/^\d+(\.\d{1,2})?$/',
            'notes'=> 'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'specNames'=>'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'specValues'=>'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u'
        ]);

        $discount = '0.00%';
        $lastChar = substr($discount, -1); //Get Last Character
        $isNumber = false;
        //---If Discount In Percentage(%)---//
        if ($lastChar == "%") {
            $discountInNumbmer = substr($discount, 0, -1); //Remove Last Character
            $isNumber = is_numeric($discountInNumbmer);
            $lastChar = substr($discount, -1);
            $request['discount'] =  $discountInNumbmer;
        }

        //--- If Dicount In Percentage(%)---//
        if ($lastChar == "%") {
            $discount =  $discountInNumbmer;
            $salePrice =   $request->sale_price;
            $amount = ($salePrice / 100);
            $discountAmount = $amount * $discount;
            $request['discount'] = $discountAmount;
        }

        
        
        if ($request->type == "serialize") {
            $request->validate([
                'itemsInBox' => 'required',
                'serialNumbers' => 'required',
                'stockQuantities' => 'required'
            ]);
        }
        if ($request->hasFile('image')) {
            $request->validate([
                'image'   =>  'image|max:2048'
            ]);

            $productImage = $request->file('image');
            $name = $productImage->getClientOriginalName();
            $uploadPath = 'upload/product_images/thumbs/';
            $uploadResizePath = 'upload/product_images/resizes/';
            $uploadPathOriginal = 'upload/product_images/';
            $imageName = time() . $name;
            $imageUrl = $uploadPath . $imageName;
            $resizeUrl = $uploadResizePath . $imageName;
            //--resize image upload in public--//
            Image::make($productImage)->resize(360, 360)->save($resizeUrl);
            Image::make($productImage)->resize(100, 100)->save($imageUrl);
            //--original image upload in public--//
            $request->image->move(public_path($uploadPathOriginal), $imageName);

            // End Image Resize
        } else {
            $imageName = "no_image.png";
        }

        DB::beginTransaction();
        try {
            $productCode = Product::where('deleted','=','No')->where('status','=','Active')->max('code');
            //return $productCode;
            $productCode++;
            $productCode = str_pad($productCode, 6, '0', STR_PAD_LEFT);
            $product = new Product();
            $product->name = $request->name;
            $product->image = $imageName;
            $product->code = $productCode;
            if ($request->barcode_no == '') {
                $barcode_no = $productCode;
            } else {
                $barcode_no = '';
            }
            $product->barcode_no = $barcode_no;
            $product->category_id = 3;
            $product->brand_id = 3;
            $product->unit_id = 3;
            $product->opening_stock = 0;
            $product->current_stock = 0;
            $product->remainder_quantity = 0;
            $product->purchase_price = $request->purchase_price;
            $product->sale_price = $request->sale_price;
            
            $product->notes = $request->notes;
            $product->model_no = '0123';
            $product->created_by = auth()->user()->id;
            $product->created_date = date('Y-m-d H:i:s');
            $product->type = 'service';
            $product->stock_check = $request->stockCheck;
            $product->items_in_box = $request->itemsInBox;
            $product->save();
            $productId = $product->id;
            // Serialize Product
            if ($request->type == "serialize") {
                $serialNumbers = explode(",", $request->serialNumbers);
                $stockQuantities = explode(",", $request->stockQuantities);
                $k = 0;
                foreach ($serialNumbers as $serialNumber) {
                    $serialize = new SerializeProduct();
                    $serialize->tbl_productsId = $productId;
                    $serialize->serial_no = $serialNumber;
                    $serialize->quantity = $stockQuantities[$k];
                    $serialize->warehouse_id = $request->stock_warehouse;
                    $serialize->created_by = auth()->user()->id;
                    $serialize->created_date = date('Y-m-d H:i:s');
                    $serialize->save();
                    $k++;
                }
            }
            $specNames = explode(",", $request->specNames);
            $specValues = explode(",", $request->specValues);
            if ($specNames[0] != -1 || $specValues[0] != -1) {
                $i = 0;
                foreach ($specNames as  $specName) {
                    $spec = new Productspecification();
                    $spec->tbl_product_id  = $productId;
                    $spec->specification_name = $specName;
                    $spec->specification_value = $specValues[$i];
                    $spec->created_by = auth()->user()->id;
                    $spec->created_date = date('Y-m-d H:i:s');
                    $spec->save();
                    $i++;
                }
            }
            // Currentstock
            
                DB::commit();
                return response()->json(['success' => 'Service saved successfully']);
            
           
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => "rollBack! Please try again"]);
        }
    }












    public function edit(Request $request)
    {
        $product = Product::find($request->id);
        $productSpecs = DB::table('tbl_inventory_product_specification')
            ->where('tbl_product_id', $product->id)
            ->where('deleted', 'No')
            ->get();
        return response()->json([$product, $productSpecs]);
    }





    public function editOpenStock(Request $request)
    {
        $product = Product::find($request->id);
        $productSpecs = DB::table('tbl_inventory_product_specification')
            ->where('tbl_product_id', $product->id)
            ->where('deleted', 'No')
            ->get();
        $currentStocks = DB::table('tbl_currentstock')
            ->join('tbl_setups_warehouses', 'tbl_currentstock.tbl_wareHouseId', '=', 'tbl_setups_warehouses.id')
            ->join('tbl_inventory_products', 'tbl_currentstock.tbl_productsId', '=', 'tbl_inventory_products.id')
            ->select('tbl_setups_warehouses.name', 'tbl_currentstock.initialStock', 'tbl_currentstock.currentStock', 'tbl_inventory_products.name', 'tbl_inventory_products.code')
            ->where('tbl_currentstock.deleted', 'No')
            ->where('tbl_currentstock.tbl_productsId', $request->id)
            ->where('tbl_currentstock.initialStock', '>', 0)
            ->orderBy('tbl_setups_warehouses.id', 'DESC')
            ->get();
        $initialStockData = '';
        foreach ($currentStocks as $currentStock) {
            $initialStockData .= '<tr>
                                    <td>' . $currentStock->name . '</td>
                                    <td>' . $currentStock->initialStock . '</td>
                                    <td>' . $currentStock->currentStock . '</td>
                                </tr>';
        }
        // Start Serialize Products
        $serializeProductRows = '';
        if ($product->type == "serialize") {
            $serializeProducts = DB::table('tbl_inventory_serialize_products')
                ->select(
                    'tbl_inventory_serialize_products.id',
                    'tbl_inventory_serialize_products.tbl_productsId',
                    'tbl_inventory_serialize_products.warehouse_id',
                    'tbl_inventory_serialize_products.serial_no',
                    'tbl_inventory_serialize_products.quantity',
                    'tbl_inventory_serialize_products.used_quantity'
                )
                ->where('tbl_inventory_serialize_products.tbl_productsId', $product->id)
                ->whereNull('tbl_inventory_serialize_products.purchase_id')
                ->where('tbl_inventory_serialize_products.deleted', 'No')
                ->where('tbl_inventory_serialize_products.status', 'Active')
                ->where('tbl_inventory_serialize_products.is_sold', 'ON')
                ->orderBy('tbl_inventory_serialize_products.id', 'ASC')
                ->get();

            $product_id =  $request->id;
            if (count($serializeProducts) > 0) {
                foreach ($serializeProducts as $key => $serializeProduct) {
                    $tblSerializeProductsId = $serializeProduct->id;
                    $serializeProductRows .= '<tr id="row' . ($key + 1) . '"><td>' . ($key + 1) . '</td>' .
                        '<td><input class="form-control input-sm serialNo' . $key .
                        '" id="editSerialNo" type="text" name="serialNo" placeholder=" Serial... " value="' . $serializeProduct->serial_no . '" required></td><td><input class="form-control only-number input-sm stockQuantity' . $key .
                        '" id="stockQuantity_' . $tblSerializeProductsId . '" type="text" name="stockQuantity" placeholder=" ... " required oninput="updateCalculateTotalQuantity(this.value,' . $product_id . ',' . $serializeProduct->warehouse_id . ',' . $tblSerializeProductsId . ')" onblur="updateCalculateTotalQuantity(' . $product_id . ',' . $serializeProduct->warehouse_id  . ',' . TRUE . ')" value="' . $serializeProduct->quantity  . '"></td></tr>';
                }
            } else {
                $serializeProductRows = '<h5 class="text-dark text-bolder text-center">No Serialize Product Available!</h5>';
            }
        }
        // End Serialize Products
        return response()->json(['product' => $product, 'productSpecs' => $productSpecs, 'initialStockData' => $initialStockData, 'serializeProductRows' => $serializeProductRows]);
    }









    public function update(Request $request)
    {         
           return $request;
       
        $discount = $request->discount;
        $lastChar = substr($discount, -1); //get last character
        $isNumber = false;
        //---if dicount in percentage(%)---//
        if ($lastChar == "%") {
            $discountInNumbmer = substr($discount, 0, -1); //remove last character
            $isNumber = is_numeric($discountInNumbmer);
            $lastChar = substr($discount, -1);
            $request['discount'] =  $discountInNumbmer;
        }

        $request->validate([
            'name' => 'required|max:255|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'opening_stock' => 'required|max:7|regex:/^\d+(\.\d{1,2})?$/',
            'remainder_quantity' => 'required|max:7|regex:/^\d+(\.\d{1,2})?$/',
            'category_id' => 'required',
            'brand_id' => 'nullable',
            'unit_id' => 'required',
            'status' => 'required',
            'purchase_price' => 'required|max:10|regex:/^\d+(\.\d{1,2})?$/',
            'sale_price' => 'required|max:10|regex:/^\d+(\.\d{1,2})?$/',
            'discount' => 'numeric|nullable',
            'specNames'=>'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'specValues'=>'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'notes'=> 'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
        ]);

        //---if dicount in percentage(%)---//
        if ($lastChar == "%") {
            $discount =  $discountInNumbmer;
            $salePrice =   $request->sale_price;
            $amount = ($salePrice / 100);
            $discountAmount = $amount * $discount;
            $request['discount'] = $discountAmount;
        }

        $product = Product::find($request->id);
        $product->name = $request->name;

        if ($request->hasFile('image')) {
            $request->validate([
                'image'   =>  'image|max:2048'
            ]);
            $productImage = $request->file('image');
            $name = $productImage->getClientOriginalName();
            $uploadPath = 'upload/product_images/thumbs/';
            $uploadResizePath = 'upload/product_images/resizes/';
            $uploadPathOriginal = 'upload/product_images/';
            $imageName = time() . $name;
            $imageUrl = $uploadPath . $imageName;
            $resizeUrl = $uploadResizePath . $imageName;
            //--resize image upload in public--//
            Image::make($productImage)->resize(360, 360)->save($resizeUrl);
            Image::make($productImage)->resize(100, 100)->save($imageUrl);
            //--original image upload in public--//
            $request->image->move(public_path($uploadPathOriginal), $imageName);
            $product->image = $imageName;
        }
        //$product->code = $request->code;
        $product->barcode_no = $request->barcode_no;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->unit_id = $request->unit_id;
        $product->opening_stock = $request->opening_stock;
        $product->remainder_quantity = $request->remainder_quantity;
        $product->purchase_price = $request->purchase_price;
        $product->sale_price = $request->sale_price;
        $product->discount = $request->discount;
        $product->sister_concern_id = $request->sisterconcernid;
        $product->tbl_warehouseid = $request->stockwarewhouse;
        $product->slug = $request->Slug;
        $product->status = $request->status;
        $product->notes = $request->notes;
        $product->model_no = $request->model_no;
        $product->updated_by = auth()->user()->id;
        $product->updated_date = date('Y-m-d H:i:s');
        $product->type = $request->type;
        $product->stock_check = $request->stockCheck;
        $product->save();
        //Specs
        $specIds = (explode(",", $request->specIds));
        $specNames = (explode(",", $request->specNames));
        $specValues = (explode(",", $request->specValues));
        //New Specs
        $newSpecNames = (explode(",", $request->newSpecNames));
        $newSpecValues = (explode(",", $request->newSpecValues));
        if ($specIds[0]  != -1) {
            for ($i = 0; $i < count($specIds); $i++) {
                $specId = $specIds[$i];
                $spec =  Productspecification::find($specId);
                $spec->tbl_product_id  = $request->id;
                $spec->specification_name = $specNames[$i];
                $spec->specification_value = $specValues[$i];
                $spec->updated_by = auth()->user()->id;
                $spec->updated_date = date('Y-m-d H:i:s');
                $spec->save();
            }
        }
        if ($newSpecNames[0] != -1 || $newSpecValues[0] != -1) {
            for ($i = 0; $i < count($newSpecNames); $i++) {
                $spec = new Productspecification();
                $spec->tbl_product_id  =  $request->id;
                $spec->specification_name = $newSpecNames[$i];
                $spec->specification_value = $newSpecValues[$i];
                $spec->created_by = auth()->user()->id;
                $spec->created_date = date('Y-m-d H:i:s');
                $spec->save();
            }
        }
        return response()->json(['success' => "Product updated Successfully"]);
    }








    public function updateProductOpenStock(Request $request)
    {
        $request->validate([
            'warehouseId' => 'required',
        ]);
        DB::beginTransaction();
        try {
            $currentStock = Currentstock::where('deleted', 'No')->where('tbl_productsId', $request->productId)->where('tbl_wareHouseId', $request->warehouseId);
            $product = Product::find($request->productId);
            if ($currentStock->first()) {
                $currentStock = $currentStock->first();
                $currentDiff = $request->openingStock - $currentStock->initialStock;
                $currentStock->initialStock = $request->openingStock;
                $currentStock->save();
                $currentStock->increment('currentStock', $currentDiff);
                $product->increment('current_stock', $currentDiff);
                $product->increment('opening_stock', $currentDiff);
            } else {
                $currentstock_insert = new Currentstock();
                $currentstock_insert->tbl_productsId = $request->productId;
                $currentstock_insert->tbl_wareHouseId = $request->warehouseId;
                $currentstock_insert->currentStock = $request->openingStock;
                $currentstock_insert->initialStock = $request->openingStock;
                $currentstock_insert->entryBy = auth()->user()->id;
                $currentstock_insert->entryDate = date('Y-m-d H:i:s');
                $currentstock_insert->save();
                $product->increment('current_stock', $request->openingStock);
                $product->increment('opening_stock', $request->openingStock);
            }
            // Start Serialize Product 
            if ($product->type == "serialize") {
                $serializeProducts = DB::table('tbl_inventory_serialize_products')
                    ->where('tbl_productsId', $product->id)
                    ->where('warehouse_id', $request->warehouseId)
                    ->whereNull('purchase_id')
                    ->where('deleted', 'No')
                    ->orderBy('id', 'ASC')
                    ->pluck('id');

                if (count($serializeProducts) > 0) {
                    $tblSerializeProductIdArray = $serializeProducts->toArray(); // Convert Obejct to Array
                    // Delete Multiple Records
                    SerializeProduct::whereIn('id', $tblSerializeProductIdArray)
                        ->update([
                            'deleted' => 'Yes',
                            'deleted_by' => Auth::id(),
                            'deleted_date' => date('Y-m-d H:i:s')
                        ]);
                }
                // Serialize Product
                $serialNumbers = explode(",", $request->editSerialNumbers);
                $stockQuantities = explode(",", $request->editStockQuantities);
                $k = 0;
                // Insert New
                foreach ($stockQuantities as $stockQuantity) {
                    $serialize = new SerializeProduct();
                    $serialize->tbl_productsId = $request->productId;
                    $serialize->serial_no = $serialNumbers[$k];
                    $serialize->quantity = $stockQuantity;
                    $serialize->warehouse_id = $request->warehouseId;
                    $serialize->created_by = auth()->user()->id;
                    $serialize->created_date = date('Y-m-d H:i:s');
                    $serialize->save();
                    $k++;
                }
            }
            // End Serialize Product 
            DB::commit();
            return response()->json(['success' => "OpeningStock updated Successfully"]);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['success' => $e]);
        }
    }









    public function delete(Request $request)
    {
        $product = Product::find($request->id);
        $product->deleted = 'Yes';
        $product->status = 'Inactive';
        $product->name = $product->name . '-Deleted-' . $request->id;
        $product->code = $product->code . '-Deleted-' . $request->id;
        $product->barcode_no = $product->barcode_no . '-Deleted-' . $request->id;
        $product->deleted_by = auth()->user()->id;
        $product->deleted_date = date('Y-m-d H:i:s');
        $product->save();
        return response()->json(['success' => 'Product deleted successfully']);
    }
  



    public function deleteSpec(Request $request)
    {
        $spec =  Productspecification::find($request->id);
        $spec->deleted = 'Yes';
        $spec->deleted_by = auth()->user()->id;
        $spec->deleted_date = date('Y-m-d H:i:s');
        $spec->save();
        return response()->json(['success' => 'Product Spec deleted']);
    }












    public function damageIndex()
    {
       
        $data['products'] = Product::where('deleted', 'No')->where('type','!=','service')->get();
        $data['warehouses'] = Warehouse::where('deleted', 'No')->where('status','=','Active')->get();
        return view('admin.inventoryManagement.damage.view-damage', $data);
    }
    public function getWarehouseByProductID(Request $request)
    {
        $warehouses = DB::table('tbl_currentstock')
            ->join('tbl_setups_warehouses', 'tbl_currentstock.tbl_wareHouseId', '=', 'tbl_setups_warehouses.id')
            ->select('tbl_setups_warehouses.id', 'tbl_setups_warehouses.name')
            ->where('tbl_currentstock.deleted', 'No')
            ->where('tbl_currentstock.tbl_productsId', $request->product_id)
            ->orderBy('tbl_setups_warehouses.id', 'DESC')
            ->get();
        return $warehouses;
    }
    public function getStockByProduct_type(Request $request)
    {
        // return $request;

        if($request->Product_Type == 'broken'){
            //   return 'Broken Items';
            $currentStock = Currentstock::where('tbl_currentstock.deleted', 'No')
            ->where('tbl_currentstock.tbl_productsId', $request->product_id)
            ->where('tbl_currentstock.tbl_wareHouseId', $request->warehouse_id)
            ->pluck('broken_remaining');
              return response()->json([ 'type' => 'broken','currentStock'=>$currentStock]);
            //   return $currentStock;
        }
        else{
            $currentStock = Currentstock::where('tbl_currentstock.deleted', 'No')
            ->where('tbl_currentstock.tbl_productsId', $request->product_id)
            ->where('tbl_currentstock.tbl_wareHouseId', $request->warehouse_id)
            ->pluck('currentStock');
            return response()->json([ 'type' => 'regular','currentStock'=>$currentStock]);
        }
       
    }
    public function getStockByProductWarehouse(Request $request)
    {
        $currentStock = Currentstock::where('deleted', 'No')
                    ->where('tbl_productsId', $request->product_id)
                    ->where('tbl_wareHouseId', $request->warehouse_id)
                    ->pluck('currentStock');
        return $currentStock;
    }
    public function findCurrentStock(Request $request)
    {
        $product = product::find($request->id);
        return $product->current_stock;
    }

    public function getDamage()
    {
          $damages = DB::table('tbl_inventory_damage_products')
        ->join('tbl_inventory_products', 'tbl_inventory_damage_products.products_id', '=', 'tbl_inventory_products.id')
        ->leftjoin('tbl_setups_brands', 'tbl_inventory_products.brand_id', '=', 'tbl_setups_brands.id')
        ->leftjoin('tbl_setups_units', 'tbl_inventory_products.unit_id', '=', 'tbl_setups_units.id')
        ->leftjoin('tbl_setups_categories', 'tbl_inventory_products.category_id', '=', 'tbl_setups_categories.id')
        ->select('tbl_inventory_damage_products.id', 'tbl_inventory_damage_products.damage_quantity', 'tbl_inventory_damage_products.damage_date', 'tbl_inventory_damage_products.damage_order_no', 'tbl_inventory_products.image', 'tbl_inventory_products.name', 'tbl_inventory_products.code', 'tbl_inventory_products.barcode_no', 'tbl_inventory_products.opening_stock', 'tbl_inventory_products.remainder_quantity', 'tbl_inventory_products.purchase_price', 'tbl_inventory_products.sale_price', 'tbl_inventory_products.discount', 'tbl_setups_categories.name as categoryName', 'tbl_setups_brands.name as brandName', 'tbl_setups_units.name as unitName')
        ->where('tbl_inventory_damage_products.deleted', 'No')
        ->orderBy('tbl_inventory_damage_products.id', 'DESC')
        ->get();
        $output = array('data' => array());
        $i = 1;
        foreach ($damages as $damage) {
            $button = '<td style="width: 12%;">
			<div class="btn-group">
				<button type="button" class="btn btn-cyan dropdown-toggle" data-toggle="dropdown">
					<i class="fas fa-cog"></i>  <span class="caret"></span></button>
					<ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu"> 
				</li>
				<li class="action" onclick="printPurchase(' . $damage->id . ')"  ><a  class="btn" ><i class="fas fa-print"></i> View Details </a></li>
				</li>
					<li class="action"><a   class="btn"  onclick="confirmDelete(' . $damage->id . ')" ><i class="fas fa-trash-alt"></i> Delete </a></li>
					</li>
					</ul>
				</div>
			</td>';
            $output['data'][] = array(
                $i++ . '<input type="hidden" name="id" id="id" value="' . $damage->id . '" />',
                $damage->damage_date,
                '<b>Damage No: </b>' . $damage->damage_order_no,
                '<b>Name: </b>'.$damage->name . ' <br><b>Code: </b>' . $damage->code,
                '<b>Category: </b>' . $damage->categoryName . '<br><b>Brand: </b>' . $damage->brandName,
                $damage->damage_quantity . ' ' . $damage->unitName,
                $button
            );
        }
        return $output;
    }

    public function damageStore(Request $request)
    {
   
//   return $request;
       
        $request->validate([
            'damage_quantity' => 'required|max:7|regex:/^\d+(\.\d{1,2})?$/',
            'remarks' => 'nullable|max:190|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'products_id' => 'required'
        ]);
        DB::beginTransaction();
        try {
            $damageOrderNo = DamageProduct::max('damage_order_no');
            $damageOrderNo++;
            $damageOrderNo = str_pad($damageOrderNo, 6, '0', STR_PAD_LEFT);
            $DamageProduct = new DamageProduct();
            $DamageProduct->products_id = $request->products_id;
            $DamageProduct->warehouse_id = $request->warehouse_id;
            $DamageProduct->damage_quantity = $request->damage_quantity;
            $DamageProduct->remarks = $request->remarks;
            $DamageProduct->damage_date = $request->damage_date;
            $DamageProduct->damage_order_no = $damageOrderNo;
            $DamageProduct->created_by = auth()->user()->id;
            $DamageProduct->created_date = Carbon::now();
            $DamageProduct->deleted = 'No';
            $DamageProduct->save();

            Product::find($request->products_id)->decrement('current_stock', $request->damage_quantity);

            if ($request->damage_quantity > 0 && $request->warehouse_id > 0) {
            
              $stockEntry = DB::table('tbl_currentstock')
                    ->where('tbl_productsId', $request->products_id)
                    ->where('tbl_wareHouseId', '=', $request->warehouse_id)
                    ->where('deleted', '=', 'No');
                if ($stockEntry->get()) {
                    if($request->ProductType=='regular'){
                        $stockEntry->decrement('currentStock', $request->damage_quantity);
                        $stockEntry->increment('damageProducts', $request->damage_quantity);
                    }
                   else  if($request->ProductType=='broken'){
                        $stockEntry->decrement('currentStock', $request->current_stock);
                        $stockEntry->decrement('broken_remaining', $request->damage_quantity);
                        $stockEntry->increment('broken_damage', $request->damage_quantity);
                    }

                } else {
                    $currentStock = new Currentstock();
                    $currentStock->tbl_productsId = $request->products_id;
                    $currentStock->tbl_wareHouseId = $request->warehouse_id;
                    $currentStock->currentStock = -$request->damage_quantity;
                    $currentStock->damageProducts = $request->opening_stock;
                    $currentStock->entryBy = auth()->user()->id;
                    $currentStock->entryDate = date('Y-m-d H:i:s');
                    $currentStock->save();
                }
            }
            DB::commit();
            return response()->json(['success' => 'Product damage saved successfully']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Purchase rollBack ' . $e]);
        }
    }

    public function damageDelete(Request $request)
    {
        DB::beginTransaction();
        try {
            $DamageProduct = DamageProduct::find($request->id);
            $DamageProduct->deleted = 'Yes';
            $DamageProduct->deleted_by = auth()->user()->id;
            $DamageProduct->deleted_date = date('Y-m-d H:i:s');
            $DamageProduct->save();
            Product::find($DamageProduct->products_id)->increment('current_stock', $DamageProduct->damage_quantity);
            $stockEntry = DB::table('tbl_currentstock')
                ->where('tbl_productsId', $DamageProduct->products_id)
                ->where('tbl_wareHouseId', '=', $DamageProduct->warehouse_id)
                ->where('deleted', '=', 'No');
            if ($stockEntry->get()) {
                $stockEntry->increment('currentStock', $DamageProduct->damage_quantity);
                $stockEntry->increment('damageDelete', $DamageProduct->damage_quantity);
            } else {
                $currentStock = new Currentstock();
                $currentStock->tbl_productsId = $DamageProduct->products_id;
                $currentStock->tbl_wareHouseId = $DamageProduct->warehouse_id;
                $currentStock->currentStock = $DamageProduct->damage_quantity;
                $currentStock->damageDelete = $DamageProduct->damage_quantity;
                $currentStock->entryBy = auth()->user()->id;
                $currentStock->entryDate = date('Y-m-d H:i:s');
                $currentStock->save();
            }
            DB::commit();
            return response()->json(['success' => 'Damage Product deleted successfully']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Damage Product Delete rollBack ']);
        }
    }

    public function createPDF($id)
    {
        $invoice = DB::table('tbl_inventory_damage_products')
            ->join('tbl_inventory_products', 'tbl_inventory_damage_products.products_id', '=', 'tbl_inventory_products.id')
            ->join('users', 'tbl_inventory_damage_products.created_by', '=', 'users.id')
            ->where([['tbl_inventory_damage_products.id', '=', $id], ['tbl_inventory_damage_products.deleted', '=', 'No']])
            ->select('tbl_inventory_damage_products.*', 'tbl_inventory_products.name', 'users.name as createdBy')
            ->where('tbl_inventory_damage_products.deleted', 'No')
            ->get();
        $pdf = PDF::loadView('admin.inventoryManagement.damage.damage-report', compact('invoice'));
        return $pdf->stream('damage-report-pdf.pdf', array("Attachment" => false));
    }
}