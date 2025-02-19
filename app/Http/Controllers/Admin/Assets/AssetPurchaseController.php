<?php

namespace App\Http\Controllers\Admin\Assets;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Assets\AssetProductCategory;
use App\Models\Assets\AssetProductBrand;
use App\Models\Assets\AssetProduct;
use App\Models\Assets\AssetPurchase;
use App\Models\Assets\AssetPurchaseProduct;
use App\Models\Assets\AssetSerializeProduct;
use App\Models\Assets\AssetDepreciationDetails;
use App\Models\Assets\AssetProductSpecification;
use App\Models\Setups\Unit;
use App\Models\Setups\Warehouse;
use App\Models\CompanySetting;
use App\Models\Accounts\ChartOfAccounts;
use App\Models\Crm\Party;
use App\Models\Voucher\PaymentVoucher;
use App\Models\Voucher\AccountsVoucher;
use App\Models\Voucher\AccountsVoucherDetails;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Image;
use Exception;
// use Barryvdh\DomPDF\PDF;
use PDF;

class AssetPurchaseController extends Controller
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
		$suppliers = Party::select('id', 'name')->where('deleted', 'No')->where('status', 'Active')->whereIn('party_type', ["Both", "Supplier"])->get();
		return view('admin.assets.purchase.view-purchase', compact('suppliers'));
	}

	public function add()
	{
		$data['categories'] = AssetProductCategory::where('deleted', 'No')->where('status', 'Active')->get();
		$data['brands'] = AssetProductBrand::where('deleted', 'No')->where('status', 'Active')->get();
		$data['products'] = AssetProduct::where('deleted', 'No')->where('status', 'Active')->get();
		$data['suppliers'] = Party::where('deleted', 'No')->where('status', 'Active')->whereIn('party_type', ['Supplier', 'Both'])->get();
		$data['warehouses'] = Warehouse::where('deleted', 'No')->where('status', 'Active')->get();
		$data['coas'] = ChartOfAccounts::where('deleted', 'No')->where('status', 'Active')->where('parent_id', '=', '30')->get();
		$data['sisterConcerns'] = CompanySetting::where('deleted', 'No')->where('status', '=', 'Active')->get();
		
		return view('admin.assets.purchase.add-purchase', $data);
	}


	public function supplierDue(Request $request)
	{
		$supplierDue = Party::find($request->id);
		return $supplierDue->current_due;
	}


	public function getPurchase(Request $request, $filterByTypeDateParty)
	{

		$tempFilterByTypeDatePartyArray = $filterByTypeDateParty;

		$filterByTypeDatePartyArray = explode("@", $tempFilterByTypeDatePartyArray);
		$filterBy = $filterByTypeDatePartyArray[0]; //  filterType d
		$filteringData = $filterByTypeDatePartyArray[1]; // days/partyId

		if ($filterBy === "days") {

			if ($filteringData != "Today") {
				$filteringData = Carbon::now()->subDays($filteringData)->format('Y-m-d 00:00:01');
				$request->request->add(['filterByDate' => $filteringData]);
			} else {
				$filteringData = Carbon::now()->toDateString(); //=> "2020-03-09"
				$request->request->add(['filterByDate' => $filteringData]);
			}
		} else {
			$request->request->add(['filterByParty' => $filteringData]);
		}

		$purchases = DB::table('tbl_asset_purchases')
			->join('tbl_crm_parties', 'tbl_asset_purchases.supplier_id', '=', 'tbl_crm_parties.id')
			->leftjoin('users', 'tbl_asset_purchases.created_by', '=', 'users.id')
			->select(
				'tbl_asset_purchases.id',
				'tbl_asset_purchases.purchase_no',
				'tbl_asset_purchases.created_date',
				'tbl_asset_purchases.total_amount',
				'tbl_asset_purchases.current_payment',
				'tbl_asset_purchases.id',
				'tbl_asset_purchases.grand_total',
				'tbl_asset_purchases.status as purchaseStatus',
				'tbl_crm_parties.name',
				'tbl_crm_parties.code',
				'tbl_crm_parties.address',
				'tbl_crm_parties.contact',
				'tbl_crm_parties.alternate_contact',
				'users.name as userName'
			)
			->where('tbl_asset_purchases.deleted', 'No')
			->when($request->has('filterByDate'), function ($query) use ($request) {
				$query->where('tbl_asset_purchases.date', '>=', $request->filterByDate);
			})
			->when($request->has('filterByParty'), function ($query) use ($request) {
				$query->where('tbl_asset_purchases.supplier_id', $request->filterByParty);
			})
			->orderBy('tbl_asset_purchases.id', 'DESC')
			->get();

		$output = array('data' => array());
		$i = 1;
		foreach ($purchases as $purchase) {
			$button = '<td style="width: 12%;">
			<div class="btn-group">
				<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
					<i class="fas fa-cog"></i>  <span class="caret"></span></button>
					<ul class="dropdown-menu dropdown-menu-right" style="border: 1px solid gray;" role="menu">	
					<li class="action"><a   class="btn"  onclick="details(' . $purchase->id . ')" ><i class="fas fa-print"></i> Details </a></li>
					</li>
					<li class="action"><a   class="btn"  onclick="confirmDelete(' . $purchase->id . ')" ><i class="fas fa-trash-alt"></i> Delete </a></li>
					</li>
					</ul>
				</div>
			</td>';
			$badgeColor = '';
			if ($purchase->purchaseStatus == 'Active') {
				$badgeColor = 'success';
			} else {
				$badgeColor = 'danger';
			}
			$grandTotal = floatval($purchase->total_amount);
			$output['data'][] = array(
				$i++ . '<input type="hidden" name="id" id="id" value="' . $purchase->id . '" />',
				$purchase->purchase_no,
				date("d-m-Y h:i a", strtotime($purchase->created_date)),
				// $purchase->coaName,
				'abc',
				'<b>Name: </b>' . $purchase->name . '<br><b>Contact: </b>' . $purchase->contact . '<br><b>Alt. Contact: </b>' . $purchase->alternate_contact . '<br><b>Address: </b>' . substr(str_pad($purchase->address, 4), 0, 25),
				'<b>Total: </b>' . $purchase->total_amount . '<br><b>GrandTotal: </b>' . $grandTotal . '  <br><b>Paid : </b>' . $purchase->current_payment,
				$purchase->userName,
				'<span class="badge badge-pill badge-' . $badgeColor . ' text-center">' . $purchase->purchaseStatus . '</span>',
				$button
			);
		}
		return $output;
	}




	public function addToCart(Request $request)
	{
		$data = '';
		$available_quantity = 0;
		$checkQuantity = 0;
		$productId = null;
		$product_type = '';


		if (Session::get("asset_purchase_cart_array") != null) {
			$is_available = 0;
			foreach (Session::get("asset_purchase_cart_array") as $keys => $values) {
				if ((Session::get("asset_purchase_cart_array")[$keys]['product_id'] == $request->id && Session::get("asset_purchase_cart_array")[$keys]['warehouse_id'] == $request->warehouseId)) {
					$is_available++;
					session()->put("asset_purchase_cart_array." . $keys . ".product_quantity", Session::get("asset_purchase_cart_array")[$keys]['product_quantity'] + $request->quantity);
					$checkQuantity = Session::get("asset_purchase_cart_array")[$keys]['product_quantity'];
					$productId = $request->id;
					$product_type = Session::get("asset_purchase_cart_array")[$keys]['product_type'];
				}
			}
			if ($is_available == 0) {
				if (isset($request->id)) {
					$productInfo = AssetProduct::where('deleted', 'No')->where('type', '!=', 'service')->where('status', 'Active')->where('id', $request->id)->first();
					//$currentStockInfo = CurrentStock::where('deleted', 'No')->where('tbl_productsId', $productInfo->id)->where('tbl_wareHouseId', $request->warehouseId)->first();
					$available_quantity = 0;
					$productId = $productInfo->id;
				}
				$temQuantity = array();
				$maxNumber = array();
				if ($productInfo->type == 'serialize') {
					$maxNumber = AssetSerializeProduct::where('tbl_assetProductsId', $productId)->max('serial_no');
					$temQuantity = $request->quantity;
				}
				$checkQuantity = $request->quantity;
				$product_type = $productInfo->type;
				$item_array = [
					'product_id'               =>     $productInfo->id,
					'product_name'             =>     $productInfo->productName . ' - ' . $productInfo->productCode,
					'product_image'            =>     $productInfo->productImage,
					'warehouse_id'        	   =>     $request->warehouseId,
					'warehouse_name'           =>     $request->warehouseName,
					'product_quantity'         =>     $request->quantity,
					'available_qty'            =>     1,
					'product_type'        	   =>     $productInfo->type,
					'product_price'            =>     1,
					'items_in_box'        	   =>     1,
					'serialNumbers'        	   =>     [$maxNumber],
					'stockQuantities'          =>     [$temQuantity],
					'depreciation'             =>     'One Time Pay',
					'no_of_month'              =>     1

				];
				Session::push('asset_purchase_cart_array', $item_array);
			}
		} else {
			if (isset($request->id)) {
				$productInfo = AssetProduct::where('deleted', 'No')->where('type', 'serialize')->where('status', 'Active')->where('id', $request->id)->first();
				//$currentStockInfo = CurrentStock::where('deleted', 'No')->where('tbl_productsId', $productInfo->id)->where('tbl_wareHouseId', $request->warehouseId)->first();

				$productId = $productInfo->id;
				$checkQuantity = $request->quantity;
				$product_type = $productInfo->type;
			}
			$temQuantity = array();
			$maxNumber = array();
			if ($productInfo->type == 'serialize') {
				$serializeProduct =  DB::table('tbl_asset_serialize_products')->orderBy('id', 'desc')
					->where('tbl_assetProductsId', $productInfo->id)
					->first();
				if ($serializeProduct) {
					$maxNumber = $serializeProduct->serial_no + 1;
				}
				$temQuantity = $request->quantity;
			}

			$item_array = [
				'product_id'               =>     $productInfo->id,
				'product_name'             =>     $productInfo->productName . ' - ' . $productInfo->productCode,
				'product_image'            =>     $productInfo->productImage,
				'warehouse_id'        	   =>     $request->warehouseId,
				'warehouse_name'           =>     $request->warehouseName,
				'product_quantity'         =>     $request->quantity,
				'available_qty'            =>     1,
				'product_type'        	   =>     $productInfo->type,
				'product_price'            =>     1,
				'items_in_box'        	   =>     1,
				'serialNumbers'        	   =>     [$maxNumber],
				'stockQuantities'          =>     [$temQuantity],
				'depreciation'             =>     "One Time Pay",
				'no_of_month'              =>     1

			];
			Session::push('asset_purchase_cart_array', $item_array);
		}
		$data .= "Success";
		return response()->json(['data' => $data, 'productId' => $productId, 'quantity' => $checkQuantity, 'warehouseId' => $request->warehouseId, 'product_type' => $product_type]);
	}

	public function fetchCart()
	{
		$grandTotal = 0;
		$cart = '';
		if (Session::get('asset_purchase_cart_array') != null) {
			$i = 1;

			foreach (Session::get('asset_purchase_cart_array') as $keys => $values) {

				$unitPrice = Session::get("asset_purchase_cart_array")[$keys]["product_price"];
				$totalPrice = Session::get("asset_purchase_cart_array")[$keys]["product_quantity"] * $unitPrice;
				$productId = Session::get("asset_purchase_cart_array")[$keys]["product_id"];
				$warehouseId = Session::get("asset_purchase_cart_array")[$keys]["warehouse_id"];
				$productType = Session::get("asset_purchase_cart_array")[$keys]["product_type"];
				$depreciation = Session::get("asset_purchase_cart_array")[$keys]["depreciation"];
				$no_of_month = Session::get("asset_purchase_cart_array")[$keys]["no_of_month"];
				if ($productType == "serialize") {
					$btn = ' <a href="#" onclick="showSerializTable(' . Session::get("asset_purchase_cart_array")[$keys]["product_id"] . ', ' . Session::get("asset_purchase_cart_array")[$keys]["warehouse_id"] . ', ' . Session::get("asset_purchase_cart_array")[$keys]["product_quantity"] . ')"> <i class="fa fa-edit"> </i> </a>';
					$updateQty = "'" . "updateQty" . "'";
				} else {
					$btn = '';
					$updateQty = '';
				}
				$mnthSelected = '';
				$oneSelected = '';
				$noSelected='';
				$decrementalSelected='';
				if ($depreciation == "Monthly") {
					$mnthSelected = "selected";
					if($no_of_month ==0){
						$no_of_month=1;
					}
				}elseif($depreciation == "No Depricition"){
					$noSelected='selected';
					$no_of_month=0;
				}elseif($depreciation == "decremental_depricition") {
					$decrementalSelected = "selected";
					if($no_of_month == 0){
						$no_of_month=1;
					}
				} 
				else {
					$oneSelected = "selected";
					if($no_of_month ==0){
						$no_of_month=1;
					}elseif($no_of_month>1){
						$no_of_month=1;
					}
				}

				$cart .= '<tr><td style="text-align: center;">' . $i++ . '<input type="hidden" name="ids[]" id="id_' . $productId . '_' . $warehouseId . '" value="' . $productId . '" /><input type="hidden" name="warehouseIds[]" id="warehouse_id_' . $productId . '_' . $warehouseId . '" value="' . $productId . '" /></td>' .
					'<td>' . Session::get("asset_purchase_cart_array")[$keys]["product_name"] . ' [' . Session::get("asset_purchase_cart_array")[$keys]["warehouse_name"] . ']</td>' .
					'<span class="d-none" id="available_qty_' . $productId . '_' . $warehouseId . '">' . Session::get("asset_purchase_cart_array")[$keys]["available_qty"]  .
					'<td style="text-align: ">
						<select class="form-control depreciation" id="depreciation_' . $productId . '_' . $warehouseId . '" onchange="loadCartandUpdate(' . $productId . ',' . $warehouseId . ')" name="depreciation" >  
							<option value="Monthly" ' . $mnthSelected . '>Straight Line</option> 
							<option value="One Time Pay" ' . $oneSelected . '>One Time</option> 
							<option value="No Depricition" ' . $noSelected . '>No Depricition</option> 
							<option value="decremental_depricition" ' . $decrementalSelected . '>Reducing Balance</option> 
						</select> 
					</td>' .
					'<td style="text-align: "> <input class="form-control no_of_month" id="no_of_month_' . $productId . '_' . $warehouseId . '"  value="' . $no_of_month . '" onkeyup="loadCartandUpdate(' . $productId . ',' . $warehouseId . ')" type="number" name="no_of_month"></td>' .
					'<td><input type="text" class="form-control quantityUpdate only-number" style="text-align: center;width: 100%;" id="quantity_' . $productId . '_' . $warehouseId . '" name="quantity[]" onkeyup="loadCartandUpdate(' . $productId . ',' . $warehouseId . ',' . $updateQty . ')" value="' . Session::get("asset_purchase_cart_array")[$keys]["product_quantity"] . '" /></td>' .
					'<td>' . $btn . '</td>' .
					'<td><input type="text" class="form-control per_unit_price" style="text-align: center;width: 100%;" id="unitPrice_' . $productId . '_' . $warehouseId . '"  name="unitPrice[]" onkeyup="loadCartandUpdate(' . $productId . ',' . $warehouseId . ')" value="' . $unitPrice . '" /></td>' .
					'<td style="text-align: right;"><span id="totalPrice_' . $productId . '_' . $warehouseId . '">' . numberFormat($totalPrice) . '</span></td>' .
					'<td style="text-align: center;"><a href="#" onclick="removeCartProduct(' . Session::get("asset_purchase_cart_array")[$keys]["product_id"] . ', ' . Session::get("asset_purchase_cart_array")[$keys]["warehouse_id"] . ')" style="color:red;"><i class="fa fa-trash"> </i> </a></td></tr>';
				$grandTotal += $totalPrice;
			}
		}
		$cart .= '<tr><td colspan="7" class="text-right" > Total Tk : </td><td id="totalAmount" class="text-right"> ' . numberFormat($grandTotal) . '.00</td><td></td></tr>';
		$data = array(
			'cart' => $cart,
			'totalAmount' => $grandTotal
		);
		return response()->json(['data' => $data]);
	}

	public function removeProduct(Request $request)
	{
		$id = $request->id;
		$warehouseId = $request->warehouse_id;
		$data = '';
		$cartData = Session::get('asset_purchase_cart_array');
		foreach (Session::get("asset_purchase_cart_array") as $keys => $values) {
			if (Session::get("asset_purchase_cart_array")[$keys]['product_id'] == $id && Session::get("asset_purchase_cart_array")[$keys]['warehouse_id'] == $warehouseId) {
				unset($cartData[$keys]);
				Session::put('asset_purchase_cart_array', $cartData);
				$data = "Success";
				break;
			}
		}
		$data = "Success";
		return response()->json(['data' => $data]);
	}

	public function updateCart(Request $request)
	{
		if (Session::get("asset_purchase_cart_array") != null) {
			foreach (Session::get("asset_purchase_cart_array") as $keys => $values) {

				if (Session::get("asset_purchase_cart_array")[$keys]['product_id'] == $request->id && Session::get("asset_purchase_cart_array")[$keys]['warehouse_id'] == $request->warehouseId) {

					session()->put("asset_purchase_cart_array." . $keys . ".product_quantity", $request->quantity);
					session()->put("asset_purchase_cart_array." . $keys . ".product_price", $request->unitPrice);
					session()->put("asset_purchase_cart_array." . $keys . ".depreciation", $request->depreciation);
					session()->put("asset_purchase_cart_array." . $keys . ".no_of_month", $request->no_of_month);

					// Serialize Product
					if (Session::get("asset_purchase_cart_array")[$keys]['product_type'] == "serialize") {
						if ($request->has('product_type') && $request->product_type == true) {
							$serialNumbers = (explode(",", $request->serialNumbers));
							$stockQuantities = (explode(",", $request->stockQuantities));
							session()->put("asset_purchase_cart_array." . $keys . ".serialNumbers", $serialNumbers);
							session()->put("asset_purchase_cart_array." . $keys . ".stockQuantities", $stockQuantities);
						} else {
							/* $tempSerialNum = array(false);
							$tempQuantity = array($request->quantity);
							session()->put("asset_purchase_cart_array." . $keys . ".serialNumbers", $tempSerialNum);
							session()->put("asset_purchase_cart_array." . $keys . ".stockQuantities", $tempQuantity); */

							$tempSerialNum = [];
							$tempQuantity = [];

							for ($i = 0; $i < $request->quantity; $i++) {
								array_push($tempQuantity, 1);
								array_push($tempSerialNum, $i + 1);
							}
							session()->put("asset_purchase_cart_array." . $keys . ".serialNumbers", $tempSerialNum);
							session()->put("asset_purchase_cart_array." . $keys . ".stockQuantities", $tempQuantity);
						}
					}
					// End Serialize Product
					$data = "Success";
				}
			}
		} else {
			$data = "";
		}
		return response()->json(['data' => $data]);
	}

	public function clearCart(Request $request)
	{
		Session::forget('asset_purchase_cart_array');
		$data = "Success";
		return response()->json(['data' => $data]);
	}
	//=========== Start Serialize Product ===========//
	public function showSerializTable(Request $request)
	{
		$trId  = 0;
		$rows = '';
		$maxNumber = '';
		foreach (Session::get("asset_purchase_cart_array") as $keys => $values) {
			if (Session::get("asset_purchase_cart_array")[$keys]['product_id'] == $request->id && Session::get("asset_purchase_cart_array")[$keys]['warehouse_id'] == $request->warehouseId) {
				$product_id = Session::get("asset_purchase_cart_array")[$keys]['product_id'];
				$warehouse_id = Session::get("asset_purchase_cart_array")[$keys]['warehouse_id'];
				$items_in_box = Session::get("asset_purchase_cart_array")[$keys]['items_in_box'];
				$function = '';
				if (Session::get("asset_purchase_cart_array")[$keys]['stockQuantities'] && Session::get("asset_purchase_cart_array")[$keys]['serialNumbers'][0] != false) {
					foreach (Session::get("asset_purchase_cart_array")[$keys]['stockQuantities'] as $key => $stockQty) {
						$serialNum = Session::get("asset_purchase_cart_array")[$keys]['serialNumbers'][$key];
						if ($key == 0) {
							$function = 'onchange="generateSerialNo(this.value)"';
						}
						$rows .= '<tr id="row' . $key . '">' .
							'<td>' . ($key + 1) . '</td>' .
							'<td><input class="form-control input-sm stockQuantity' . $key .
							'" id="stockQuantity" type="text" name="stockQuantity" placeholder=" Quantity... " required oninput="calculateTotalQuantity()" onblur="loadCartandUpdate(' . $product_id . ',' . $warehouse_id . ',' . TRUE . ')" value="' . $stockQty . '"  ></td>';
						$rows .=
							'<td><input class="form-control input-sm serialNo' . $key .
							'" id="serialNo" type="text" name="serialNo" placeholder=" Serial Number... " required value="' . $serialNum . '" ' . $function . '><td><a href="#" onclick="removeRow(' . $key . ')" style="color:red;"><i class="fa fa-trash"> </i> </a></td></td></tr>';
					}
				} else {
					$tempSerialNums = array();
					$tempQuantities = array();
					$serializeProduct =  DB::table('tbl_asset_serialize_products')->orderBy('id', 'desc')
						->where('tbl_assetProductsId', $product_id)
						->first();
					if ($serializeProduct) {
						$maxNumber = $serializeProduct->serial_no;
					}
					// $totalQuantity = count(Session::get("asset_purchase_cart_array")[$keys]['stockQuantities']) == 1 ? Session::get("asset_purchase_cart_array")[$keys]['stockQuantities'][0] : 0;
					$totalQuantity = count(Session::get("asset_purchase_cart_array")[$keys]['stockQuantities']) == 1 ? Session::get("asset_purchase_cart_array")[$keys]['stockQuantities'][0] : 0;
					if ($trId == 0) {
						$function = 'onchange="generateSerialNo(this.value)"';
					}
					$avarageQty = ceil($totalQuantity / $items_in_box);
					for ($i = 0; $i < $avarageQty; $i++) {
						if ($totalQuantity < $items_in_box) {
							$items_in_box = $totalQuantity;
						}
						$rows .= '<tr id="row' . $i . '">' .
							'<td>' . ($i + 1) . '</td>' .
							'<td><input class="form-control input-sm stockQuantity' . $i .
							'" id="stockQuantity" type="text" name="stockQuantity" placeholder=" Quantity... " required oninput="calculateTotalQuantity()" onblur="loadCartandUpdate(' . $product_id . ',' . $warehouse_id . ',' . TRUE . ')" value="' . $items_in_box . '"  ></td>';
						$rows .=
							'<td><input class="form-control input-sm serialNo' . $i .
							'" id="serialNo" type="text" name="serialNo" placeholder=" Serial Number... " required value="' . ++$maxNumber . '" ' . $function . '><td><a href="#" onclick="removeRow(' . $i . ')" style="color:red;"><i class="fa fa-trash"> </i> </a></td></td></tr>';
						$tempSerialNums[$i] = $maxNumber;
						$tempQuantities[$i] = $items_in_box;
						$totalQuantity -= $items_in_box;
					}
					session()->put("asset_purchase_cart_array." . $keys . ".serialNumbers", $tempSerialNums);
					session()->put("asset_purchase_cart_array." . $keys . ".stockQuantities", $tempQuantities);
				}
			}
		}
		return response()->json(['displayTable' => $rows]);
	}
	//=========== End Serialize Product ===========//


	/*  */

	public function checkOutCart(Request $request)
	{
		//return $request;
		$sisterConcernId=Session::get("companySettings")[0]["id"];
		$request->validate([
			'supplier' => 'required',
			'product' => 'required'
		]);

		DB::beginTransaction();
		try {
			$purchaseNo            = AssetPurchase::where('deleted', 'No')->max('purchase_no');
			$purchaseNo++;
			$purchaseNo            = str_pad($purchaseNo, 6, '0', STR_PAD_LEFT);
			$purchase              = new AssetPurchase();
			$purchase->sister_concern_id = $sisterConcernId;
			$purchase->supplier_id       = $request->supplier_id;
			$purchase->purchase_no       = $purchaseNo;
			//$purchase->coa_id          = $request->category;
			$purchase->date              = $request->date;
			$purchase->total_amount      = floatval($request->total_amount);
			$grand_total                 = floatval($request->grand_total);
			$purchase->grand_total       = $grand_total;
			$purchase->selected_sister_concern = $request->selected_sister_concern;
			$purchase->previous_due      = floatval($request->previous_due);
			$purchase->current_balance   = floatval($request->current_balance);
			$purchase->total_with_due    = floatval($request->total_with_due);
			$current_payment             = floatval($request->current_payment);
			$purchase->current_payment   = $current_payment;
			$purchase->created_by        = auth()->user()->id;
			$purchase->created_date      = date('Y-m-d H:i:s');
			$purchase->save();
			$purchase_id = $purchase->id;

			$depreciationStatus='';
			foreach (Session::get("asset_purchase_cart_array") as $keys => $values) {
				$product_id        = Session::get("asset_purchase_cart_array")[$keys]["product_id"];
				$warehouse_id      = Session::get("asset_purchase_cart_array")[$keys]["warehouse_id"];
				$depreciation      = Session::get("asset_purchase_cart_array")[$keys]["depreciation"];
				$no_of_month       = Session::get("asset_purchase_cart_array")[$keys]["no_of_month"];
				$product           = AssetProduct::find($product_id);
				$unit              = $product->units;
				$unit_price        = Session::get("asset_purchase_cart_array")[$keys]["product_price"];
				if($no_of_month == 0){
					$per_month         = '0';
					$depreciationStatus= 'No';
				}else{
					$per_month         = ceil($unit_price / $no_of_month);
					$depreciationStatus='Yes';
				}
				
				$quantity          = Session::get("asset_purchase_cart_array")[$keys]["product_quantity"];
				$product->increment('purchase_quantity', $quantity);
				$subtotal          = $unit_price * $quantity;
				//$product->increment('total_purchase_price', $subtotal);
				$purchase_products  = new AssetPurchaseProduct();
				$purchase_products->asset_purchase_id  = $purchase_id;
				$purchase_products->asset_product_id   = $product_id;
				$purchase_products->warehouse_id       = $warehouse_id;
				$purchase_products->unit               = $unit;
				$purchase_products->unit_price         = floatval($unit_price);
				$purchase_products->quantity           = $quantity;
				$purchase_products->subtotal           = floatval($subtotal);
				$purchase_products->created_by         = auth()->user()->id;
				$purchase_products->created_date       = date('Y-m-d H:i:s');
				$purchase_products->save();

				$purchase_products_id = $purchase_products->id;
				$purchase_price       = $purchase_products->unit_price;

				// Start Serialize Product
				if (Session::get("asset_purchase_cart_array")[$keys]["product_type"] == 'serialize') {
					$quantity = 0;
					if (Session::get("asset_purchase_cart_array")[$keys]['stockQuantities']) {
						foreach (Session::get("asset_purchase_cart_array")[$keys]['stockQuantities'] as $key => $stockQty) {
							//$serialNum  =  Session::get("asset_purchase_cart_array")[$keys]['serialNumbers'][$key];

							$maxCode = AssetSerializeProduct::max('serial_no');
							$maxCode++;
							$maxCode = str_pad($maxCode, 6, '0', STR_PAD_LEFT);

							$serializeProduct = new AssetSerializeProduct();
							$serializeProduct->tbl_assetProductsId  = $product_id;
							$serializeProduct->serial_no            = $maxCode;
							$serializeProduct->warehouse_id         = $warehouse_id;
							$serializeProduct->price              	= $purchase_price;
							$serializeProduct->depreciation         = $depreciation;
							$serializeProduct->depricision_status  	= $depreciationStatus;
							$serializeProduct->no_of_month          = $no_of_month;
							$serializeProduct->per_month            = $per_month;
							$serializeProduct->deducted             = $per_month;
							$serializeProduct->deducted_month       = 1;
							$serializeProduct->asset_purchase_id    = $purchase_id;
							$serializeProduct->supplier_id    		= $request->supplier_id;
							$serializeProduct->quantity             = $stockQty;
							$serializeProduct->created_by           = auth()->user()->id;
							$serializeProduct->created_date         = date('Y-m-d H:i:s');
							$serializeProduct->save();
							$quantity += $stockQty;
							$serializeProduct_id = $serializeProduct->id;
							
							 
							  for($i = 0; $i < $no_of_month; $i++){

									$tenure=Date('Y-m', strtotime(Date("Y-m").' '.$i.' Month -0 Day'));
									$tenureDate=Date('Y-m-d', strtotime(Date("Y-m-d").' '.$i.' Month -0 Day'));
									$d=date('d');
									/*if($d == '31'){
										if(substr($tenureDate,-2) == '31'){
											$d='31';
										}elseif(substr($tenureDate,-2) == '01'){
											$d='30';
										}else{
											$d='28';
										}
									}elseif($d == '30'){
										if(substr($tenureDate,-2) == '02' || substr($tenureDate,-2) == '01'){
											$d='28';
										}
									}elseif($d == '29'){
										if(substr($tenureDate,-2) == '01'){
											$d='28';
										}elseif(substr($tenureDate,-2) == '29'){
											$d='29';
										}
									}*/
									$daysOfMonth = date("t", strtotime($tenureDate));
									if($d > $daysOfMonth){
										$d = $daysOfMonth;
									}
									$DepreciationDetails = new AssetDepreciationDetails();
									$DepreciationDetails->tbl_assetProductId         = $product_id;
									$DepreciationDetails->tbl_assetPurchaseProductId = $purchase_products_id;
									$DepreciationDetails->tbl_serializeId            = $serializeProduct_id;
									$DepreciationDetails->amount                     = $unit_price;
									$DepreciationDetails->deducted_amount            = $per_month;
									$DepreciationDetails->status            		 = 'Pending';
									$DepreciationDetails->deducted_date              = date($tenure.'-'.$d);
									$DepreciationDetails->created_by                 = auth()->user()->id;
									$DepreciationDetails->created_date               = date('Y-m-d H:i:s');
									$DepreciationDetails->save();
								
							 }  
							
						}
					}
				}
			}
			$party = Party::find($request->supplier_id);
			$party->decrement('current_due', ($grand_total));

			// $maxCode = PaymentVoucher::where('deleted', 'No')->max('voucherNo');
			// $maxCode++;
			// $maxCode = str_pad($maxCode, 6, '0', STR_PAD_LEFT);
			// $paymentVoucher = new PaymentVoucher();
			// $paymentVoucher->voucherNo       = $maxCode;
			// $paymentVoucher->party_id        = $request->supplier_id;
			// $paymentVoucher->tbl_asset_purchase_id     = $purchase_id;
			// $paymentVoucher->amount          = floatval($request->grand_total);
			// $paymentVoucher->payment_method  = 'Cash';
			// $paymentVoucher->paymentDate     = $request->date;
			// $paymentVoucher->type            = 'Payable';
			// $paymentVoucher->voucherType     = 'Asset Purchase';
			// $paymentVoucher->remarks         = 'payable for asset purchase code: ' . $purchaseNo . ' payment: ' . $request->grand_total;
			// $paymentVoucher->entryBy         = auth()->user()->id;
			// $paymentVoucher->save();

			// if($request->current_payment > 0){
				
			// 	$party = Party::find($request->supplier_id);
			// 	$party->increment('current_due', ($request->current_payment));
				
			// 	$maxCode = PaymentVoucher::where('deleted', 'No')->max('voucherNo');
			// 	$maxCode++;
				
			// 	$maxCode = str_pad($maxCode, 6, '0', STR_PAD_LEFT);
			// 	$paymentVoucher = new PaymentVoucher();
			// 	$paymentVoucher->voucherNo       = $maxCode;
			// 	$paymentVoucher->party_id        = $request->supplier_id;
			// 	$paymentVoucher->tbl_asset_purchase_id     = $purchase_id;
			// 	$paymentVoucher->amount          = floatval($request->current_payment);
			// 	$paymentVoucher->payment_method  = 'Cash';
			// 	$paymentVoucher->paymentDate     = $request->date;
			// 	$paymentVoucher->type            = 'Payment';
			// 	$paymentVoucher->voucherType     = 'Asset Purchase';
			// 	$paymentVoucher->remarks         = 'Paid for asset purchase code: ' . $purchaseNo . ' paid: ' . $request->current_payment;
			// 	$paymentVoucher->entryBy         = auth()->user()->id;
			// 	$paymentVoucher->save();
			// 	//return $paymentVoucher->id;
			// }
			


			// /* accounts part start */
			// $voucher = new AccountsVoucher();
			// $voucher->vendor_id = $party->id;
			// $voucher->transaction_date = $request->date;
			// $voucher->asset_purchase_id = $purchase_id;
			// $voucher->amount = floatval($request->grand_total);
			// $voucher->payment_method = $request->payment_method;
			// $voucher->payment_voucher_id = $paymentVoucher->id;
			// $voucher->deleted = "No";
			// $voucher->status = "Active";
			// $voucher->created_by = Auth::user()->id;
			// $voucher->created_date = date('Y-m-d h:s');
			// $voucher->save();
			// $voucherId = $voucher->id;

			
			// $cashId = ChartOfAccounts::where('slug', '=', 'cash')->first();
			// $assetId = ChartOfAccounts::where('slug', '=', 'Asset')->first();

			

			// $voucherDetails = new AccountsVoucherDetails();
			// $voucherDetails->tbl_acc_voucher_id = $voucherId;
			// $voucherDetails->tbl_acc_coa_id = $assetId->id;
			// $voucherDetails->credit = floatval($request->grand_total);
			// $voucherDetails->voucher_title = 'Asset value adjusted with asset purchase Code ' . $purchase_id;
			// $voucherDetails->voucher_id = $purchase_id;
			// $voucherDetails->payment_voucher_id = $paymentVoucher->id;
			// $voucherDetails->deleted = "No";
			// $voucherDetails->status = "Active";
			// $voucherDetails->created_by = Auth::user()->id;
			// $voucherDetails->created_date = date('Y-m-d H:i:s');
			// $voucherDetails->save();

			// if ($request->current_payment > 0) {
			// 	$voucherDetails = new AccountsVoucherDetails();
			// 	$voucherDetails->tbl_acc_voucher_id = $voucherId;
			// 	$voucherDetails->tbl_acc_coa_id = $cashId->id;
			// 	$voucherDetails->debit = floatval($request->current_payment);
			// 	$voucherDetails->voucher_title = 'Asset purchase amount paid with asset Purchase Code ' . $purchase_id;
			// 	$voucherDetails->voucher_id = $purchase_id;
			// 	$voucherDetails->payment_voucher_id = $paymentVoucher->id;
			// 	$voucherDetails->deleted = "No";
			// 	$voucherDetails->status = "Active";
			// 	$voucherDetails->created_by = Auth::user()->id;
			// 	$voucherDetails->created_date = date('Y-m-d h:s');
			// 	$voucherDetails->save();
			// }
			// $cash = ChartOfAccounts::find($cashId->id);
			// $cash->decrement('amount', $request->current_payment);

			
			// $asset = ChartOfAccounts::find($assetId->id);
			// $asset->increment('amount', $request->grand_total);

			

			Session::forget('asset_purchase_cart_array');
			DB::commit();
			return response()->json(['Success' => 'Product purchased successfully', 'purchaseId' => $purchase_id]);
		} catch (Exception $e) {
			DB::rollBack();
			return response()->json(['error' => $e->getMessage()]);
		}
	}

	public function delete(Request $request)
	{
		DB::beginTransaction();
		try {
			$purchase = AssetPurchase::find($request->id);
			$purchase->deleted = 'Yes';
			$purchase->deleted_date = date('Y-m-d H:i:s');
			$purchase->save();

			$currentPaymentInCash = $purchase->current_payment;

			$party = Party::find($purchase->supplier_id);
			$party->current_due = ($party->current_due - $purchase->current_payment + $purchase->grand_total);
			$party->save();

			$purchase_products = AssetPurchaseProduct::where("asset_purchase_id", $request->id)->get();
			foreach ($purchase_products as $purchase_product) {
				$purchaseProduct = AssetPurchaseProduct::find($purchase_product->id);
				$purchaseProduct->deleted = 'Yes';
				$purchaseProduct->deleted_date = date('Y-m-d H:i:s');
				$purchaseProduct->deleted_by = auth()->user()->id;
				$purchaseProduct->save();

				$product = AssetProduct::find($purchase_product->asset_product_id);
				$quantity = intval($purchaseProduct->quantity);
				$unit_price = floatval($product->unit_price);
				$product->decrement('purchase_quantity', $quantity);

				$subtotal = floatval($unit_price * $quantity);
				//$product->decrement('total_purchase_price', $subtotal);
			}
			$purchaseId = $request->id;
			$result = AssetSerializeProduct::where('asset_purchase_id', $purchaseId)->update(['deleted' => 'Yes', 'status'=>'No','deleted_by' => auth()->user()->id, 'deleted_date' => date('Y-m-d H:i:s')]);
			$result2 = PaymentVoucher::where('tbl_asset_purchase_id', $purchaseId)->update(['deleted' => 'Yes', 'deleted_by' => auth()->user()->id, 'deleted_date' => date('Y-m-d H:i:s')]);

			DB::commit();
			return response()->json(['Success' => 'Asset Purchase deleted!']);
		} catch (Exception $e) {
			DB::rollBack();
			return response()->json(['error' => $e->getMessage()]);
		}
	}




	public function invoice($id){

		$assetPurchase=DB::table('tbl_asset_purchases')
				->leftjoin('users','tbl_asset_purchases.created_by','=','users.id')
				->leftjoin('tbl_crm_parties','tbl_asset_purchases.supplier_id','=','tbl_crm_parties.id')
				->select('tbl_asset_purchases.*','users.name as UserName','tbl_crm_parties.name as partyName','tbl_crm_parties.contact_person','tbl_crm_parties.contact','tbl_crm_parties.address')
				->where('tbl_asset_purchases.id','=',$id)
				->where('tbl_asset_purchases.deleted','=','No')
				->first();

		$products=DB::table('tbl_asset_serialize_products')
				->leftjoin('tbl_asset_products','tbl_asset_products.id','=','tbl_asset_serialize_products.tbl_assetProductsId')
				->leftjoin('users','tbl_asset_serialize_products.sold_by','=','users.id')
				->select('tbl_asset_serialize_products.*',
							'tbl_asset_products.productName',
							'tbl_asset_products.productCode',
							'users.name as userName'
							)
				->where('tbl_asset_serialize_products.asset_purchase_id','=',$id)
				->get();

		$assetProducts=DB::table('tbl_asset_purchase_products')
						->leftJoin('tbl_asset_products','tbl_asset_purchase_products.asset_product_id','=','tbl_asset_products.id')
						->select('tbl_asset_purchase_products.*','tbl_asset_products.productName','tbl_asset_products.productCode')
						->where('tbl_asset_purchase_products.asset_purchase_id','=',$id)
						->get();

		$pdf = PDF::loadView('admin.assets.purchase.asset-purchase-report',
																			[	'assetPurchase'=>$assetPurchase,
																				'products'=>$products,
																				'assetProducts'=>$assetProducts
																			]);
		return $pdf->stream('purchase-report-pdf.pdf', array("Attachment" => false));
	}











}