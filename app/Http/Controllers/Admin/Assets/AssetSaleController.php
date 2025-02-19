<?php

namespace App\Http\Controllers\Admin\Assets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assets\AssetProductCategory;
use App\Models\Assets\AssetProductBrand;
use App\Models\Assets\AssetProduct;
use App\Models\Assets\AssetSale;
use App\Models\Setups\Unit;
use App\Models\Setups\Warehouse;
use App\Models\Accounts\ChartOfAccounts;
use App\Models\Assets\AssetSerializeProduct;
use App\Models\Assets\AssetDepreciationDetails;
use App\Models\Crm\Party;
use App\Models\Accounts\PaymentVoucher;
use App\Models\Accounts\Voucher;
use App\Models\Accounts\VoucherDetails;
use App\Models\Accounts\AccountConfiguration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Image;
use Exception;
use DateTime;
use Illuminate\Support\Facades\Cache;
use PDF;

class AssetSaleController extends Controller
{
    public function index()
	{
		
		Cache::flush();
		//$customers = Party::select('id', 'name')->where('deleted', 'No')->where('status', 'Active')->whereIn('party_type', ["Both", "Supplier"])->get();
		return view('admin.assets.sales.view-asset-sale');
	}

    public function create(){
        $data['categories'] = AssetProductCategory::where('deleted', 'No')->where('status', 'Active')->get();
		$data['brands'] = AssetProductBrand::where('deleted', 'No')->where('status', 'Active')->get();
		$data['products'] = AssetProduct::where('deleted', 'No')->where('status', 'Active')->get();
		$data['suppliers'] = Party::where('deleted', 'No')->where('status', 'Active')->whereIn('party_type', ['Supplier', 'Both'])->get();
		$data['warehouses'] = Warehouse::where('deleted', 'No')->where('status', 'Active')->get();
        $asset=ChartOfAccounts::where('slug','=','Asset')->first();
		$data['coas'] = ChartOfAccounts::where('deleted', 'No')->where('status', 'Active')->where('parent_id', '=', $asset->id)->orwhere('id','=',$asset->id)->get();
        return view('admin.assets.sales.add-asset-sale', $data);
    }



	public function getAssetSales(Request $request){
		
		$assetSales=DB::table('tbl_asset_sales')
				->leftjoin('users','tbl_asset_sales.created_by','=','users.id')
				->select('tbl_asset_sales.*','users.name')
				->where('tbl_asset_sales.deleted','=','No')
				->orderby('id','DESC')
				->get();

		$output = array('data' => array());

		$i = 1;
		$button='';
		$text='';
		$depreciations='';
		$totalTenure=0;
		$depreciationAmount=0;
		foreach ($assetSales as $sale) {
			/* $depreciations=AssetDepreciationDetails::where('tbl_serializeId','=',$product->id)->where('status','=','Paid')->get();
			$totalTenure=count($depreciations);
				foreach($depreciations as $depreciation){
					$depreciationAmount +=$depreciation->amount;
				} */
			$button = '<td style="width: 12%;">
			<div class="btn-group">
			<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
			<i class="fas fa-cog"></i>  <span class="caret"></span></button>
			<ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu">
			<li class="action" onclick="details(' . $sale->id . ')"  ><a  class="btn" ><i class="fas fa-print"></i> Details</a></li>
			</ul>
			</div>
			</td>'; 
			

			$output['data'][] = array(

			$i++,
			date("d-m-Y",strtotime($sale->date)),
			$sale->sale_no,
			$sale->party_name,
			$sale->name,
			$sale->total_amount.' '. Session::get('companySettings')[0]['currency'],
			$sale->discount.' '. Session::get('companySettings')[0]['currency'],
			$sale->grand_total.' '. Session::get('companySettings')[0]['currency'],
			$sale->current_payment.' '. Session::get('companySettings')[0]['currency'],
			$button
			);

		}

		return $output;
	}

	public function getSerializeProduct(Request $request){
		$assetSerializeProducts=DB::table('tbl_asset_serialize_products')
								->leftjoin('tbl_asset_products','tbl_asset_products.id','=','tbl_asset_serialize_products.tbl_assetProductsId')
								->select('tbl_asset_serialize_products.*','tbl_asset_products.productName','tbl_asset_products.productCode')
								->where('tbl_asset_serialize_products.tbl_assetProductsId','=',$request->product_id)
								->where('tbl_asset_serialize_products.is_sold','=','OFF')
								->get();
		$html='';
		$html .='	<label> Serialize Products : <span class="text-danger">*</span></label>
					<select id="serialize_product_id" name="serialize_product_id" class="form-control input-sm" style="width:96%" onchange="add_to_serialize_cart()">
						<option value=""> Choose Serialize Products </option>';
		foreach ($assetSerializeProducts as $product){
			$html .='<option value="'.$product->id.'">'. $product->productName . ' - Serial No: ' . $product->serial_no .'</option>';
		}								
		$html .='</select>';
		return $html;
	}


	public function addToCart(Request $request){
		$salePrice=0;
		$product=AssetSerializeProduct::where('id','=',$request->id)->first();
		$purchaseDate= date("Y-m-d",strtotime($product->created_date));
		$currentDate = date("Y-m-d");
		$depreciationDatas=AssetDepreciationDetails::where('tbl_serializeId','=',$request->id)
						->where('deducted_date','>=',$purchaseDate)
						->where('deducted_date','<=',$currentDate)
						//->where('status','=','Pending')
						->get();

		$depreciationTotal=0;
		
		if(count($depreciationDatas) > 1){
			foreach($depreciationDatas as $depreciation){
				$depreciationTotal += $depreciation->deducted_amount;
				$depreciationChange=AssetDepreciationDetails::find($depreciation->id);
				$depreciationChange->status="Paid";
				$depreciationChange->paid_month_year=date("Y-m",strtotime($depreciation->deducted_date));
				$depreciationChange->save();
			}
		}
		
		
		if($product->depreciation == 'One Time Pay'){
			$salePrice=$product->price;
		}else{
			$salePrice = $product->price - $depreciationTotal;
		}
		
		$data='';
		$is_available = 0;
		if(Session::get("asset_sale_cart_array") != null){
			
			foreach (Session::get("asset_sale_cart_array") as $keys => $values){
				
				if ((Session::get("asset_sale_cart_array")[$keys]['id'] == $request->id && Session::get("asset_sale_cart_array")[$keys]['warehouse_id'] == $request->warehouseId)){
					$is_available++;
					//session()->put("asset_sale_cart_array." . $keys . ".product_quantity", Session::get("asset_sale_cart_array")[$keys]['product_quantity'] + $request->quantity);
					$data = "Success";
				}
			}
		}
		
		if($is_available == 0){
			$productInfo=DB::table('tbl_asset_serialize_products')
				->leftjoin('tbl_asset_products','tbl_asset_products.id','=','tbl_asset_serialize_products.tbl_assetProductsId')
				->leftjoin('tbl_warehouse','tbl_warehouse.id','=','tbl_asset_serialize_products.warehouse_id')
				->select('tbl_asset_serialize_products.*','tbl_asset_products.productName','tbl_asset_products.productCode','tbl_warehouse.wareHouseName as warehouseName')
				->where('tbl_asset_serialize_products.id','=',$request->id)
				->where('tbl_asset_serialize_products.warehouse_id','=',$request->warehouseId)
				->first();



				$unitPrice=0;
				if($productInfo){
					$item_array = [
						'id'               		   =>     $productInfo->id,
						'product_name'             =>     $productInfo->productName . ' - ' . $productInfo->productCode,
						'product_serial'           =>     $productInfo->serial_no,
						'product_quantity'         =>     $request->quantity,
						'depreciation_value'       =>     $salePrice,
						'unit_price'         	   =>     $salePrice,
						'warehouse_id'        	   =>     $request->warehouseId,
						'warehouse_name'           =>     $request->warehouseName,
					]; 
					Session::push('asset_sale_cart_array', $item_array);
					$data = "Success";
				}
			}else{
				$data = "You have already selected this product.";
				/* test */
			}
		
		
		return $data;
	}



	public function fetchCart(Request $request){
		$grandTotal = 0;
		$cart = '';
		if (Session::get('asset_sale_cart_array') != null) {
			$i = 1;
			
			foreach (Session::get('asset_sale_cart_array') as $keys => $values) {
				$productId = Session::get("asset_sale_cart_array")[$keys]["id"];
				$productName = Session::get("asset_sale_cart_array")[$keys]["product_name"];
				$productSerial = Session::get("asset_sale_cart_array")[$keys]["product_serial"];
				$productQuantity = Session::get("asset_sale_cart_array")[$keys]["product_quantity"];
				$unitPrice = Session::get("asset_sale_cart_array")[$keys]["unit_price"];
				$depreciationValue = Session::get("asset_sale_cart_array")[$keys]["depreciation_value"];
				$totalPrice = Session::get("asset_sale_cart_array")[$keys]["product_quantity"] * Session::get("asset_sale_cart_array")[$keys]["unit_price"];
				$warehouseId = Session::get("asset_sale_cart_array")[$keys]["warehouse_id"];
				$warehouseName = Session::get("asset_sale_cart_array")[$keys]["warehouse_name"];

				$cart .='<tr>
							<td>'.$i++.'<input type="hidden" name="ids[]" id="id_'.$productId .'" value="' . $productId . '" /><input type="hidden" name="warehouseIds[]" id="warehouse_id_' . $productId . '_' . $warehouseId . '" value="' . $productId . '" /></td>
							<td>'.$productName.'</td>
							<td>'.$productSerial.'</td>
							<td class="text-center">'.$productQuantity.'<input type="hidden" name="quantity[]" id="quantity_' . $productId .'" value="' . $productQuantity . '" /></td>
							<td class="text-center"><input type="number" class="form-control text-center" name="unitPrice[]" id="unitPrice_' . $productId .'" value="' . $unitPrice . '" onkeyup="updateCart(' . $productId . ')"/></td>
							<td class="text-right"><span id="totalPrice_'.$productId .'">' . number_format($totalPrice,2) . '</span></td>
							<td class="text-center"><a href="#" onclick="removeCartProduct(' . Session::get("asset_sale_cart_array")[$keys]["id"] . ')" style="color:red;"><i class="fa fa-trash"> </i></a></td>
						</tr>';
						$grandTotal += $totalPrice;
			}
		}	
		$cart .='<tr>
					<td colspan="5" class="text-right" > Total Tk : </td>
					<td class="text-right " id="total_amount"> ' . $grandTotal . '</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="5" class="text-right" > Discount : </td>
					<td class="text-right " ><input type="text" id="discount" class="text-right only-number form-control" onkeyup="calculateTotal()"></td>
					<td></td>
				</tr>';
		$data = array(
			'cart' => $cart,
			'totalAmount' => $grandTotal
		);
		return response()->json(['data' => $data]);
	}




	public function clearCart(Request $request)
	{
		Session::forget('asset_sale_cart_array');
		$data = "Success";
		return response()->json(['data' => $data]);
	}









	public function updateCart(Request $request)
	{
		if (Session::get("asset_sale_cart_array") != null) {
			foreach (Session::get("asset_sale_cart_array") as $keys => $values) {
				if (Session::get("asset_sale_cart_array")[$keys]['id'] == $request->id) {
					session()->put("asset_sale_cart_array." . $keys . ".product_quantity", $request->quantity);
					session()->put("asset_sale_cart_array." . $keys . ".unit_price", $request->unitPrice);
					// End Serialize Product
					$data = "Success";
					break;
				}
			}
		} else {
			$data = "";
		}
		return response()->json(['data' => $data]);
	}







	public function removeProduct(Request $request)
	{
		 $id = $request->id;
		//$warehouseId = $request->warehouse_id;
		$data = '';
		$cartData = Session::get('asset_sale_cart_array');
		foreach (Session::get("asset_sale_cart_array") as $keys => $values) {
			if (Session::get("asset_sale_cart_array")[$keys]['id'] == $id) {
				unset($cartData[$keys]);
				Session::put('asset_sale_cart_array', $cartData);
				$data = "Success";
				break;
			}
		}
		$data = "Success";
		return response()->json(['data' => $data]);
	}






	public function checkOutCart(Request $request){
		//return $request->product_id;
		$request->validate([
			'customer_name' 	=> 'required|max:255|regex:/^([a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+\s)*[a-zA-Z0-9_ "\.\-\s\,\;\:\/\&\$\%\(\)]+$/u',
			'date' 				=> 'required',
			'total_amount' 		=> 'required',

		]);
		DB::beginTransaction();
		try {
			$assetSaleNo= AssetSale::where('deleted','=','No')->max('sale_no');
			$assetSaleNo++;
			$assetSaleNo=str_pad($assetSaleNo, 6, '0', STR_PAD_LEFT);
			$assetSale = new AssetSale();
			$assetSale->method_name= $request->payment_method;
			$assetSale->sale_no= $assetSaleNo;
			$assetSale->date= $request->date;
			$assetSale->total_amount= $request->total_amount;
			$assetSale->discount= $request->discount;
			$assetSale->grand_total= $request->grand_total;
			$assetSale->current_payment= $request->current_payment;
			$assetSale->party_name= $request->customer_name;
			$assetSale->coa_id= $request->coa_id;
			$assetSale->created_by= auth()->user()->id;
			$assetSale->created_date= date('Y-m-d H:i:s');
			$assetSale->save();
			$assetSaleId=$assetSale->id;
			$totalDepreciationValue=0;
			foreach(Session::get("asset_sale_cart_array") as $keys => $value){
				$productId = Session::get("asset_sale_cart_array")[$keys]["id"];
				$unitPrice = Session::get("asset_sale_cart_array")[$keys]["unit_price"];
				$depreciationValue = Session::get("asset_sale_cart_array")[$keys]["depreciation_value"];
				
				$assetSerializeProduct=AssetSerializeProduct::find($productId);
				$assetSerializeProduct->is_sold='ON';
				$assetSerializeProduct->sold_price=$unitPrice;
				$assetSerializeProduct->price_after_depreciation=$depreciationValue;
				$assetSerializeProduct->sold_date= date('Y-m-d H:i:s');
				$assetSerializeProduct->updated_by= auth()->user()->id;
				$assetSerializeProduct->asset_sale_id= $assetSaleId;
				$assetSerializeProduct->sold_by= auth()->user()->id;
				$assetSerializeProduct->status= 'No';
				$assetSerializeProduct->save();
				$totalDepreciationValue += $depreciationValue;
			}
			
			if (floatval($request->grand_total) > 0) {
				$party = Party::where('name','=','Asset Customer')->first();
				$maxCode = PaymentVoucher::where('deleted', 'No')->max('voucherNo');
				$maxCode++;
				$maxCode = str_pad($maxCode, 6, '000000', STR_PAD_LEFT);;
				$paymentVoucher = new PaymentVoucher();
				$paymentVoucher->party_id = $party->id;
				$paymentVoucher->voucherNo = $maxCode;
				$paymentVoucher->tbl_asset_sale_id = $assetSaleId;
				$paymentVoucher->amount = floatval($request->grand_total);
				$paymentVoucher->payment_method = 'Cash';
				$paymentVoucher->paymentDate  = $request->date;
				$paymentVoucher->type  = 'Party Payable';
				$paymentVoucher->voucherType  = 'Asset Sale';
				$paymentVoucher->remarks  = 'Asset Sale for Asset Sale code: ' . $assetSale->sale_no . ' payment: ' . $request->grand_total;
				$paymentVoucher->entryBy  = auth()->user()->id;
				$paymentVoucher->save();
				if (floatval($request->current_payment) > 0) {
					$maxCode = PaymentVoucher::where('deleted', 'No')->max('voucherNo');
					$maxCode++;
					$maxCode = str_pad($maxCode, 6, '000000', STR_PAD_LEFT);
					$paymentVoucher = new PaymentVoucher();
					$paymentVoucher->voucherNo = $maxCode;
					$paymentVoucher->party_id = $party->id;
					$paymentVoucher->tbl_asset_sale_id = $assetSaleId;
					$paymentVoucher->amount = floatval($request->current_payment);
					$paymentVoucher->payment_method = 'Cash';
					$paymentVoucher->paymentDate  = $request->date;
					$paymentVoucher->type  = 'Payment Received';
					$paymentVoucher->voucherType  = 'Asset Sale';
					$paymentVoucher->remarks  = 'Asset Sale for Asset Sale code: ' . $assetSale->sale_no . ' payment: ' . $request->grand_total;
					$paymentVoucher->entryBy  = auth()->user()->id;
					$paymentVoucher->save();
				}
			}

			/* accounts part start */
			$voucher = new Voucher();
			$voucher->vendor_id = $party->id;
			$voucher->transaction_date = $request->date;
			$voucher->asset_sale_id = $assetSaleId;
			$voucher->amount = floatval($request->grand_total);
			$voucher->payment_method = $request->payment_method;
			$voucher->payment_voucher_id = $paymentVoucher->id;
			$voucher->deleted = "No";
			$voucher->status = "Active";
			$voucher->created_by = Auth::user()->id;
			$voucher->created_date = date('Y-m-d h:s');
			$voucher->save();
			$voucherId = $voucher->id;

			
			$cashId = ChartOfAccounts::where('slug', '=', 'cash')->first();
			$assetId = ChartOfAccounts::where('slug', '=', 'Asset')->first();
			$otherIncome = ChartOfAccounts::where('slug', '=', 'other-income')->first();

			$voucherDetails = new VoucherDetails();
			$voucherDetails->tbl_acc_voucher_id = $voucherId;
			$voucherDetails->tbl_acc_coa_id = $assetId->id;
			$voucherDetails->debit = floatval($request->grand_total);
			$voucherDetails->voucher_title = 'Asset value adjusted with asset Sale Code ' . $assetSaleId;
			$voucherDetails->voucher_id = $assetSaleId;
			$voucherDetails->payment_voucher_id = $paymentVoucher->id;
			$voucherDetails->deleted = "No";
			$voucherDetails->status = "Active";
			$voucherDetails->created_by = Auth::user()->id;
			$voucherDetails->created_date = date('Y-m-d H:i:s');
			$voucherDetails->save();

			if ($request->current_payment > 0) {
				$voucherDetails = new VoucherDetails();
				$voucherDetails->tbl_acc_voucher_id = $voucherId;
				$voucherDetails->tbl_acc_coa_id = $cashId->id;
				$voucherDetails->credit = floatval($request->current_payment);
				$voucherDetails->voucher_title = 'Asset Sale amount paid with asset Sale Code ' . $assetSaleId;
				$voucherDetails->voucher_id = $assetSaleId;
				$voucherDetails->payment_voucher_id = $paymentVoucher->id;
				$voucherDetails->deleted = "No";
				$voucherDetails->status = "Active";
				$voucherDetails->created_by = Auth::user()->id;
				$voucherDetails->created_date = date('Y-m-d h:s');
				$voucherDetails->save();
			}

			$othersIncomeValue=0;
			$othersIncomeValue=$request->current_payment - $totalDepreciationValue;
			//return $totalDepreciationValue;
			$cash = ChartOfAccounts::find($cashId->id);
			$cash->increment('amount', $request->current_payment);

			$asset = ChartOfAccounts::find($assetId->id);
			$asset->decrement('amount', $totalDepreciationValue);

			$othersIncome = ChartOfAccounts::find($otherIncome->id);
			$othersIncome->increment('amount', $othersIncomeValue);

			Session::forget('asset_sale_cart_array');
			DB::commit();
			return response()->json(['Success' => 'Sales successfully done', 'assetSaleId' => $assetSaleId]);
		} catch (Exception $e) {
			DB::rollBack();
			return response()->json(['error' => $e->getMessage()]);
		}
		//return $request;
	}




		public function invoice($id){
			
			$assetSale=DB::table('tbl_asset_sales')
				->leftjoin('users','tbl_asset_sales.created_by','=','users.id')
				->select('tbl_asset_sales.*','users.name')
				->where('tbl_asset_sales.id','=',$id)
				->where('tbl_asset_sales.deleted','=','No')
				->first();
			 $products=DB::table('tbl_asset_serialize_products')
				->leftjoin('tbl_asset_products','tbl_asset_products.id','=','tbl_asset_serialize_products.tbl_assetProductsId')
				->leftjoin('users','tbl_asset_serialize_products.sold_by','=','users.id')
				->select('tbl_asset_serialize_products.*',
							'tbl_asset_products.productName',
							'tbl_asset_products.productCode',
							'users.name as userName'
							)
				->where('tbl_asset_serialize_products.asset_sale_id','=',$id)
				->where('tbl_asset_serialize_products.is_sold','=','ON')
				->get();
			//return view('admin.assets.sales.asset-sale-report',['assetSale'=>$assetSale,'products'=>$products]);
			$pdf = PDF::loadView('admin.assets.sales.asset-sale-report',  ['assetSale'=>$assetSale,'products'=>$products]);
			return $pdf->stream('sale-report-pdf.pdf', array("Attachment" => false));
		}









































}