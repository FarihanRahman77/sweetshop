<?php

namespace App\Http\Controllers\Admin\Assets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Assets\AssetProductCategory;
use App\Models\Assets\AssetProductBrand;
use App\Models\Assets\AssetProduct;
use App\Models\Assets\AssetProductSpecification;
use App\Models\Assets\AssetDepreciationDetails;
use App\Models\Setups\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Image;
use DateTime;
use PDF;


class AssetProductController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:products.view', ['only' => ['index', 'getProducts']]);
        // $this->middleware('permission:products.store', ['only' => ['store']]);
        // $this->middleware('permission:products.edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:products.delete', ['only' => ['delete']]);
        // // Damage
        // $this->middleware('permission:damage.view', ['only' => ['damageIndex', 'getDamage']]);
        // $this->middleware('permission:damage.store', ['only' => ['damageStore']]);
        // $this->middleware('permission:damage.delete', ['only' => ['damageDelete']]);
    } 

    public function index()
    {
        
        
        $data['categories'] = AssetProductCategory::where('deleted', 'No')->where('status','=','Active')->get();
        $data['brands'] = AssetProductBrand::where('deleted', 'No')->where('status','=','Active')->get();
        $data['units'] = Unit::where('deleted', 'No')->where('status','=','Active')->get();
        return view('admin.assets.assetProducts', $data);
    }


    public function getproducts()
    {
        $products = DB::table('tbl_asset_products')
            ->join('tbl_asset_product_brands', 'tbl_asset_products.tbl_assetBrandId', '=', 'tbl_asset_product_brands.id')
            ->join('tbl_asset_product_categories', 'tbl_asset_products.tbl_assetCategoryId', '=', 'tbl_asset_product_categories.id')
            ->select('tbl_asset_products.id', 'tbl_asset_products.status', 'tbl_asset_products.productImage', 'tbl_asset_products.productName', 'tbl_asset_products.modelNo', 'tbl_asset_products.productCode', 'tbl_asset_products.units', 'tbl_asset_product_categories.name as categoryName', 'tbl_asset_product_brands.name as brandName')
            ->where('tbl_asset_products.deleted', 'No')
            ->orderBy('tbl_asset_products.id', 'DESC')
            ->get();
        $output = array('data' => array());
        $i = 1;
        $imageUrl='';
        foreach ($products as $product) {
            $status = "";
            if ($product->status == 'Active') {
                $status = '<center><i class="fas fa-check-circle" style="color:green; font-size:16px;"></i></center>';
            } else {
                $status = '<center><i class="fas fa-times-circle" style="color:red; font-size:16px;"></i></center>';
            }
            if($product->productImage == 'no_image.png'){
                $imageUrl = url('upload/no_image.png');
            }else{
                $imageUrl = url('upload/asset_product_images/thumbs/' . $product->productImage);
            }
            
      
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
           
            $output['data'][] = array(
                $i++ . '<input type="hidden" name="id" id="id" value="' . $product->id . '" />',
                '<b>Name: </b>'.$product->productName . '<br><b>Model: </b>' . $product->modelNo . '<br><b>Code: </b>' . $product->productCode,
                '<b>Category: </b>' . $product->categoryName . ' <br><b>Brand: </b>' . $product->brandName . '<br><b>Unit: </b>' . $product->units ,
                '<center><img style="max-width:50px; max-height:80px;" src="' . $imageUrl  . '" alt="no_image" /></center>',
                $status,
                $button
            );
        }
        return $output;
    }


    public function getAdvanceSearchProducts(Request $request)
    {

        $products = DB::table('products')
            ->join('brands', 'products.brand_id', '=', 'brands.id')
            ->join('units', 'products.unit_id', '=', 'units.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('products.id', 'products.status', 'products.image', 'products.name', 'products.code', 'products.barcode_no', 'products.opening_stock', 'products.current_stock', 'products.remainder_quantity', 'products.purchase_price', 'products.sale_price', 'products.discount', 'categories.name as categoryName', 'brands.name as brandName', 'units.name as unitName')
            ->where('products.deleted', 'No')
            ->orderBy('products.id', 'DESC')
            ->get();
        $output = array('data' => array());
        $i = 1;
        foreach ($products as $product) {
            $productId = $product->id;
            $specs = DB::table('tbl_productspecification')->where('deleted', 'No')->where('tbl_productsId', $productId)->get();
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


    public function store(Request $request)
    {
       
        
        $request->validate([
            'name' => 'required|max:255|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'category_id' => 'required',
            'brand_id' => 'required',
            'units' => 'required',
            'model_no' => 'nullable',
            'code' => 'required',
            'specNames'=>'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'specValues'=>'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'notes'=> 'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u'
        ]);
       //return $request;

        // if ($request->type == "serialize") {
        //     $request->validate([
        //         'itemsInBox' => 'required',
        //         'serialNumbers' => 'required',
        //         'stockQuantities' => 'required'
        //     ]);
        // }

        if ($request->hasFile('image')) {
            $request->validate([
                'image'   =>  'image|max:2048'
            ]);

            $productImage = $request->file('image');
            $name = $productImage->getClientOriginalName();
            $uploadPath = 'upload/asset_product_images/thumbs/';
            $uploadResizePath = 'upload/asset_product_images/resizes/';
            $uploadPathOriginal = 'upload/asset_product_images/';
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
            $productCode = AssetProduct::where('deleted','=','No')->where('status','=','Active')->max('productCode');
            $productCode++;
            $productCode = str_pad($productCode, 6, '0', STR_PAD_LEFT);

            $product = new AssetProduct();
            $product->productName = $request->name;
            $product->productImage = $imageName;
            $product->productCode = $productCode;
            $product->tbl_assetCategoryId = $request->category_id;
            $product->tbl_assetBrandId = $request->brand_id;
            $product->units = $request->units;
            $product->notes = $request->notes;
            $product->modelNo = $request->model_no;
            $product->created_by = auth()->user()->id;
            $product->created_date = date('Y-m-d H:i:s');
            $product->save();
            $productId = $product->id;
        

            $specNames = explode(",", $request->specNames);
            $specValues = explode(",", $request->specValues);
            if ($specNames[0] != -1 || $specValues[0] != -1) {
                $i = 0;
                foreach ($specNames as  $specName) {
                    $spec = new AssetProductSpecification();
                    $spec->tbl_assetProductId  = $productId;
                    $spec->specificationName = $specName;
                    $spec->specificationValue = $specValues[$i];
                    $spec->created_by = auth()->user()->id;
                    $spec->created_date = date('Y-m-d H:i:s');
                    $spec->save();
                    $i++;
                }
            }
       
            DB::commit();
            return response()->json(['success' => 'Product saved successfully']);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error' => "rollBack! Please try again"]);
        }
    }


    public function editProduct(Request $request)
    {
        $product = AssetProduct::find($request->id);
        $productSpecs = DB::table('tbl_asset_product_specifications')
            ->where('tbl_assetProductId', $product->id)
            ->where('deleted', 'No')
            ->get();
        return response()->json([$product, $productSpecs]);
    }
  

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'category_id' => 'required',
            'brand_id' => 'required',
            'unit' => 'required',
            'status' => 'required',
            'specNames'=>'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'specValues'=>'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
            'notes'=> 'nullable|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
        ]);

        $product = AssetProduct::find($request->id);
        $product->productName = $request->name;

        if ($request->hasFile('image')) {
            $request->validate([
                'image'   =>  'image|max:2048'
            ]);
            $productImage = $request->file('image');
            $name = $productImage->getClientOriginalName();
            $uploadPath = 'upload/asset_product_images/thumbs/';
            $uploadResizePath = 'upload/asset_product_images/resizes/';
            $uploadPathOriginal = 'upload/asset_product_images/';
            $imageName = time() . $name;
            $imageUrl = $uploadPath . $imageName;
            $resizeUrl = $uploadResizePath . $imageName;
            //--resize image upload in public--//
            Image::make($productImage)->resize(360, 360)->save($resizeUrl);
            Image::make($productImage)->resize(100, 100)->save($imageUrl);
            //--original image upload in public--//
            $request->image->move(public_path($uploadPathOriginal), $imageName);
            $product->productImage = $imageName;
        }

        $product->tbl_assetCategoryId = $request->category_id;
        $product->tbl_assetBrandId = $request->brand_id;
        $product->units = $request->unit_id;
        $product->status = $request->status;
        $product->notes = $request->notes;
        $product->modelNo = $request->model_no;
        $product->updated_by = auth()->user()->id;
        $product->updated_date = date('Y-m-d H:i:s');

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
                $spec =  AssetProductSpecification::find($specId);
                $spec->tbl_assetProductId  = $request->id;
                $spec->specificationName = $specNames[$i];
                $spec->specificationValue = $specValues[$i];
                $spec->updated_by = auth()->user()->id;
                $spec->updated_date = date('Y-m-d H:i:s');
                $spec->save();
            }
        }
        if ($newSpecNames[0] != -1 || $newSpecValues[0] != -1) {
            for ($i = 0; $i < count($newSpecNames); $i++) {
                $spec = new AssetProductSpecification();
                $spec->tbl_assetProductId  =  $request->id;
                $spec->specificationName = $newSpecNames[$i];
                $spec->specificationValue = $newSpecValues[$i];
                $spec->created_by = auth()->user()->id;
                $spec->created_date = date('Y-m-d H:i:s');
                $spec->save();
            }
        }
        return response()->json(['success' => "Product updated Successfully"]);
    }

    public function delete(Request $request)
    {
        $product = AssetProduct::find($request->id);
        $product->deleted = 'Yes';
        $product->status = 'Inactive';
        $product->deleted_by = auth()->user()->id;
        $product->deleted_date = date('Y-m-d H:i:s');
        $product->save();
        return response()->json(['success' => 'Product deleted successfully']);
    }

    public function deleteSpec(Request $request)
    {
        $spec =  AssetProductSpecification::find($request->id);
        $spec->deleted = 'Yes';
        $spec->deletedBy = auth()->user()->id;
        $spec->deletedDate = date('Y-m-d H:i:s');
        $spec->save();
        return response()->json(['success' => 'Product Spec deleted']);
    }






    public function depriciationProducts(){
        
		return view('admin.assets.depreciation.depreciationProducts');

	}

    public function getDepreciationAssets(Request $request){

        $assetDepreciationProducts=DB::table('tbl_asset_serialize_products')
                                ->leftjoin('tbl_asset_products','tbl_asset_products.id','=','tbl_asset_serialize_products.tbl_assetProductsId')
                                ->leftjoin('tbl_asset_purchases','tbl_asset_purchases.id','=','tbl_asset_serialize_products.asset_purchase_id')
                                ->leftjoin('users','tbl_asset_serialize_products.created_by','=','users.id')
                                ->leftjoin('tbl_crm_parties','tbl_asset_serialize_products.supplier_id','=','tbl_crm_parties.id')
                                ->select('tbl_asset_serialize_products.*','tbl_asset_products.productName',
                                'tbl_asset_products.productCode','users.name as userName','tbl_crm_parties.name as partyName','tbl_crm_parties.contact as partyContact')
                                ->where('tbl_asset_serialize_products.depreciation','=','Monthly')
                                ->orwhere('tbl_asset_serialize_products.depreciation','=','decremental_depricition')
                                ->where('tbl_asset_serialize_products.is_sold','=','OFF')
                                ->where('tbl_asset_serialize_products.deleted','=','No')
                                ->where('tbl_asset_serialize_products.status','=','Yes')
                                ->get();
        
        $output = array('data' => array());
        $i = 1;
        $button='';
        foreach ($assetDepreciationProducts as $product) {
			 $button = '<td style="width: 12%;">
			<div class="btn-group">
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
					<i class="fas fa-cog"></i>  <span class="caret"></span></button>
					<ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu">
						<li class="action" onclick="seeTenure(' . $product->id . ')"  ><a  class="btn" ><i class="fa fa-calendar"></i> Tenure Details</a></li>
					</ul>
				</div>
			</td>'; 
			 $badgeColor = '';
			 $status='';
			if ($product->status == 'Yes') {
				$badgeColor = 'success';
				$status="Available";
			} else {
				$badgeColor = 'danger';
				$status="Not Available";
			} 
			
			$output['data'][] = array(
				$i++,
				date("d-m-Y h:i a",strtotime($product->created_date)),
				$product->productName,
                $product->serial_no,
				'<b>Name : </b>'.$product->partyName.'<br> <b>Mobile : </b>'.$product->partyContact,
                $product->userName,
                $product->price,
				'<span>'.$product->per_month.' Taka '.$product->depreciation.' depreciation for '.$product->no_of_month.' years</span>',
                '<span>Amount : '.$product->deducted.'<br> Tenure : '.$product->deducted_month.'</span>',
				$product->per_month,
				$button
			);
			
		}
		
		return $output;
        
    }



    public function depreciationAssetsPdf(){

        $assetDepreciationProducts=DB::table('tbl_asset_serialize_products')
                                ->leftjoin('tbl_asset_products','tbl_asset_products.id','=','tbl_asset_serialize_products.tbl_assetProductsId')
                                ->leftjoin('tbl_asset_purchases','tbl_asset_purchases.id','=','tbl_asset_serialize_products.asset_purchase_id')
                                ->leftjoin('users','tbl_asset_serialize_products.created_by','=','users.id')
                                ->leftjoin('tbl_crm_parties','tbl_asset_serialize_products.supplier_id','=','tbl_crm_parties.id')
                                ->select('tbl_asset_serialize_products.*','tbl_asset_products.productName',
                                'tbl_asset_products.productCode','users.name as userName','tbl_crm_parties.name as partyName','tbl_crm_parties.contact as partyContact')
                                ->where('tbl_asset_serialize_products.depreciation','=','Monthly')
                                ->orwhere('tbl_asset_serialize_products.depreciation','=','decremental_depricition')
                                ->where('tbl_asset_serialize_products.is_sold','=','OFF')
                                ->where('tbl_asset_serialize_products.deleted','=','No')
                                ->where('tbl_asset_serialize_products.status','=','Yes')
                                ->get();
                                
        $pdf = PDF::loadView('admin.assets.depreciation.depreciationAssetReport',['assetDepreciationProducts'=>$assetDepreciationProducts]);
		return $pdf->stream('depreciation-asset-report-pdf.pdf', array("Attachment" => false));
    }



    public function getDepreciationTenure(Request $request){

            $product=DB::table('tbl_asset_serialize_products')
                    ->leftjoin('tbl_asset_products','tbl_asset_products.id','=','tbl_asset_serialize_products.tbl_assetProductsId')
                    ->select('tbl_asset_serialize_products.*','tbl_asset_products.productName')
                    ->where('tbl_asset_serialize_products.id','=',$request->id)
                    ->first();

            $tenureDetails=AssetDepreciationDetails::where('tbl_serializeId','=',$request->id)->get();

            $html='';
            $span='';
            $html .='<table width="100%" class="table table-bordered table-hover">
                    <tr>
                        <th>SL.</th>
                        <th>Tenure</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                
                ';
            $lastTenure=AssetDepreciationDetails::where('tbl_serializeId','=',$request->id)->orderBy('id','DESC')->first();
            $purchaseDate = new DateTime(date("Y-m-d",strtotime($product->created_date)));
            $currentDate = new DateTime(date("Y-m-d"));
            $purchaseToCurrentDateInterval = $purchaseDate->diff($currentDate);
            $depreciationYear= $purchaseToCurrentDateInterval->y; 
            $depreciationAmount=$product->price - ($product->per_month * $depreciationYear);
            $i=1;
        foreach($tenureDetails as $tenure){
            $html .='<tr>
                        <th>'.$i++.'</th>
                        <th>'.date("d-m-Y h:i a",strtotime($tenure->deducted_date)).'</th>
                        <th>'.$tenure->deducted_amount.'</th>
                        <th><span>Paid</span></th>
                    </tr>
                ';
                if($i > $depreciationYear){
                    break;
                } 
            }
            $html .='</table>';
            $span .=$product->productName.'-'.$product->serial_no;

            $data=array(
                'span'=>$span,
                'html'=>$html
            );
        return $data;
    }



    public function cloaseDepreciation(){
        return view('admin.assets.depreciation.closeDepreciation');
    }



    public function getDepreciationProductsYearwise(Request $request){
        //return $request->to_date;
        $from_date = date("Y-m-t", strtotime($request->to_date));
          $depreciations=DB::table('tbl_asset_depreciation_details')
                        ->leftJoin('tbl_asset_products','tbl_asset_products.id','=','tbl_asset_depreciation_details.tbl_assetProductId')
                        ->leftJoin('tbl_asset_serialize_products','tbl_asset_serialize_products.id','=','tbl_asset_depreciation_details.tbl_serializeId')
                        ->select('tbl_asset_depreciation_details.*','tbl_asset_products.productName','tbl_asset_serialize_products.serial_no')
                        ->where('tbl_asset_depreciation_details.deducted_date','>=',$request->to_date)
                        ->where('tbl_asset_depreciation_details.deducted_date','<=',$from_date)
                        ->where('tbl_asset_depreciation_details.status','=','Pending')
                        ->get();
        if(count($depreciations) > 0){
            $html='';
            $html .=' <table id="dataTable" width="100%" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <td width="5%" class="text-center">SL</td>
                                <td width="15%" class="text-center">Deprecition Date</td>
                                <td width="20%" class="text-center">Product Info</td>
                                <td width="20%" class="text-center">Serial</td>
                                <td width="15%" class="text-right">Depreciation Price</td>
                                <td width="15%" class="text-right">Deducted</td>
                                <td width="5%" class="text-center">Actions</td>
                            </tr>
                        </thead>
                        <tbody>';
                $sl=1;
            foreach($depreciations as $depreciation){
                $html .='<tr>
                            <td width="5%" class="text-center">'.$sl++.'</td>
                            <td width="15%" class="text-center">'.$depreciation->deducted_date.'</td>
                            <td width="20%" class="text-center">'.$depreciation->productName.'</td>
                            <td width="20%" class="text-center">'.$depreciation->serial_no.'</td>
                            <td width="15%" class="text-right">'.$depreciation->amount.'</td>
                            <td width="15%" class="text-center">'.$depreciation->status.'</td>
                            <td width="5%" class="text-center"></td>
                        </tr>
                        ';
            }
            $html .= '    </tbody>
                    </table>';
            
            $data= array(
                'html'=>$html,
                'from_date'=>$from_date
             );
             return $data;
        }else{
            $paidDepreciations=DB::table('tbl_asset_depreciation_details')
                        ->leftJoin('tbl_asset_products','tbl_asset_products.id','=','tbl_asset_depreciation_details.tbl_assetProductId')
                        ->leftJoin('tbl_asset_serialize_products','tbl_asset_serialize_products.id','=','tbl_asset_depreciation_details.tbl_serializeId')
                        ->select('tbl_asset_depreciation_details.*','tbl_asset_products.productName','tbl_asset_serialize_products.serial_no')
                        ->where('tbl_asset_depreciation_details.deducted_date','>=',$request->to_date)
                        ->where('tbl_asset_depreciation_details.deducted_date','<=',$from_date)
                        ->where('tbl_asset_depreciation_details.status','=','Paid')
                        ->where('tbl_asset_depreciation_details.status','!=','Pending')
                        ->get();
            $message='';
            if($paidDepreciations){
                 $message='All depreciations of month is Paid';
                 $data= array(
                    'message'=>$message,
                    'from_date'=>$from_date
                 );
                 return $data;
            }
        }
        
    }


    public function saveDepriciationTenure(Request $request){
        $depreciations=DB::table('tbl_asset_depreciation_details')
                        ->leftJoin('tbl_asset_products','tbl_asset_products.id','=','tbl_asset_depreciation_details.tbl_assetProductId')
                        ->leftJoin('tbl_asset_serialize_products','tbl_asset_serialize_products.id','=','tbl_asset_depreciation_details.tbl_serializeId')
                        ->select('tbl_asset_depreciation_details.*','tbl_asset_products.productName','tbl_asset_serialize_products.serial_no')
                        ->where('tbl_asset_depreciation_details.deducted_date','>=',$request->to_date)
                        ->where('tbl_asset_depreciation_details.deducted_date','<=',$request->from_date)
                        ->where('tbl_asset_depreciation_details.status','=','Pending')
                        ->get();
        if(count($depreciations) > 0){
            foreach($depreciations as $depreciation){
                $payDepreciation=AssetDepreciationDetails::find($depreciation->id);
                $payDepreciation->status='Paid';
                $payDepreciation->paid_month_year =$request->month_year;
                $payDepreciation->save();
            }
            return response()->json(['Success' => 'Saved successfully']);
        }else{
            return response()->json(['message' => 'No pending depreciation left.']);
        }
        
    }








}
    